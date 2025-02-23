<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\PaymentModel;

class PaymentController extends BaseController
{
    public function checkout()
    {
        $paymentModel = new PaymentModel();
        $cartModel = new CartModel();
        $session = session();
        $userId = $session->get('user_id');

        // Save payment data
        $data = [
            'user_id' => $userId,
            'total' => $this->request->getVar('total_price'),
            'status' => 'waitiing_confirmation',
            'deleted_at' => null
        ];
        $paymentModel->save($data);
        $paymentId = $paymentModel->getInsertID();

        $cartModel
            ->where('user_id', $userId)
            ->where('status', 'cart')
            ->set(['status' => 'waiting_payment'])
            ->update();

        return redirect()->to(base_url('/waiting-payment?paymentId=' . $paymentId));
    }


    public function waitingPayment()
    {
        $paymentId = $this->request->getGet('paymentId');
        $data = [
            'paymentId' => $paymentId
        ];

        return view('customer/v_waiting_payment', $data);
    }

    public function alreadyTransferred()
    {
        $paymentModel = new PaymentModel();
        $cartModel = new CartModel();
        $session = session();

        // Get user ID and payment ID
        $userId = $session->get('user_id');
        $paymentId = $this->request->getGet('paymentId');

        // Validate user ID and payment ID
        if (!$userId || !$paymentId) {
            return redirect()->to(base_url('/error'))->with('error', 'Invalid request');
        }

        // Validate file upload
        $file = $this->request->getFile('proof_of_transfer');
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->to(base_url('/error'))->with('error', 'Invalid file upload');
        }

        // Move uploaded file
        $fileName = $file->getRandomName();
        $file->move('assets/images', $fileName);

        // Update payment with proof of transfer
        $paymentModel
            ->where('payment_id', $paymentId)
            ->set([
                'proof_of_transfer' => '/assets/images/' . $fileName,
                'status' => 'waiting_confirmation'
            ])
            ->update();

        // Update cart status to 'checking_payment'
        $cartModel
            ->where('user_id', $userId)
            ->where('status', 'waiting_payment') // Only update carts with status 'cart'
            ->set(['status' => 'checking_payment'])
            ->update();

        // Redirect to checking payment page
        return redirect()->to(base_url('/checking-payment'));
    }

    public function checkingPaymentView()
    {
        return view('customer/v_checking_payment');
    }

    public function checkingPayment()
    {
        $cartModel = new CartModel();
        $session = session();
        $userId = $session->get('user_id');

        // Count total carts with 'checking_payment' status
        $totalChecking = $cartModel
            ->where('user_id', $userId)
            ->where('status', 'checking_payment')
            ->countAllResults();

        // Count total carts with 'success_payment' status
        $totalSuccess = $cartModel
            ->where('user_id', $userId)
            ->where('status', 'success_payment')
            ->countAllResults();

        // Check if all products have 'success_payment' status
        $isPaymentSuccess = ($totalChecking === 0 && $totalSuccess > 0);

        if ($isPaymentSuccess) {
            $cartModel
                ->where('user_id', $userId)
                ->where('status', 'checking_payment') // Only update carts with status 'cart'
                ->set(['status' => 'success_payment'])
                ->update();
        }

        // Return true or false as JSON
        return $this->response->setJSON($isPaymentSuccess);
    }

    public function successPaymentView()
    {
        return view('customer/v_success_payment');
    }

    public function managePaymentView()
    {
        $paymentModel = new PaymentModel();

        $payments = $paymentModel
            ->join('users', 'users.user_id = payments.user_id')
            ->where('payments.deleted_at', null)
            ->findAll();

        $data = [
            'payments' => $payments,
        ];

        return view('admin/payment/v_payment', $data);
    }

    public function confirmPayment($paymentId)
    {
        $cartModel = new CartModel();
        $paymentModel = new PaymentModel();
    
        // Mengambil data pembayaran berdasarkan payment_id
        $payment = $paymentModel->where('payment_id', $paymentId)->first();
    
        // Periksa apakah data pembayaran ditemukan
        if (!$payment) {
            session()->setFlashdata('error', 'Payment not found.');
            return redirect()->to('/admin/manage-payment');
        }
    
        // Update semua status cart yang terkait user_id ke 'success_payment'
        $updated = $cartModel
            ->where('user_id', $payment['user_id'])
            ->where('status', 'checking_payment')
            ->set(['status' => 'success_payment'])
            ->update();
    
        // Update status pembayaran menjadi 'confirmed'
        $paymentUpdate = $paymentModel
            ->where('payment_id', $paymentId)
            ->set(['status' => 'confirmed'])
            ->update();
    
        // Periksa apakah semua proses berhasil
        if ($updated && $paymentUpdate) {
            session()->setFlashdata('message', 'Confirm payment successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to confirm payment.');
        }
    
        // Redirect kembali ke halaman manage payment
        return redirect()->to('/admin/manage-payment');
    }
}
