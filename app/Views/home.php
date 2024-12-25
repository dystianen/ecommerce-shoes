<?= $this->extend('./layouts/BaseLayout.php') ?>

<?= $this->section('content') ?>

<section class="bg d-flex align-items-center" style="height: 670px">
  <div class="row align-items-center" style="height: 100%">
    <div class="gap-4 flex-column col-7 d-flex">
      <h1 class="text-primary" style="font-size: 70px; font-weight: 700">FIND SHOES <br> THAT MATCHES <br> YOUR STYLE</h1>
      <p>Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.</p>
      <button class="px-5 rounded-pill btn btn-primary btn-lg" style="width: max-content;">Shop Now</button>

      <div class="row">
        <div class="col">
          <h3 class="text-primary" style="font-weight: 700">200+</h3>
          <p>International Brands</p>
        </div>
        <div class="col">
          <h3 class="text-primary" style="font-weight: 700">300+</h3>
          <p>High-Quality Products</p>
        </div>
        <div class="col">
          <h3 class="text-primary" style="font-weight: 700">40,000+</h3>
          <p>Happy Customers</p>
        </div>
      </div>
    </div>
    <div class="col" style="position: relative; height: 100%">
      <img src="/imgs/people-style-2.png" alt="people-style-2">
      <div style="position: absolute; bottom: 80px; right: 0px">
        <img src="/imgs/people-style-1.png" alt="people-style-1">
      </div>
    </div>
  </div>

</section>

<section>
  <div class="row">
    <div class="col">
      <img src="/imgs/logo_converse.svg" alt="">
    </div>
    <div class="col">
      <img src="/imgs/logo_adidas.svg" alt="">
    </div>
    <div class="col">
      <img src="/imgs/logo_reebok.svg" alt="">
    </div>
    <div class="col">
      <img src="/imgs/logo_nb.svg" alt="">
    </div>
    <div class="col">
      <img src="/imgs/logo_jordan.svg" alt="">
    </div>
    <div class="col">
      <img src="/imgs/logo_asics.svg" alt="">
    </div>
  </div>
</section>

<section class="d-flex flex-column align-items-center" style="margin-top: 40px">
  <h3 class="text-primary" style="font-weight: 700; font-size: 48px">NEW ARRIVALS</h3>

  <div class="row">
    <div class="col card-product">
      <img src="/imgs/logo_converse.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
    <div class="col card-product">
      <img src="/imgs/logo_adidas.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
    <div class="col card-product">
      <img src="/imgs/logo_reebok.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
    <div class="col card-product">
      <img src="/imgs/logo_nb.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
    <div class="col card-product">
      <img src="/imgs/logo_jordan.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
    <div class="col card-product">
      <img src="/imgs/logo_asics.svg" alt="">
      <h5 style="font-weight: 600;">Nike Air Max</h5>

    </div>
  </div>
</section>

<?= $this->endSection() ?>