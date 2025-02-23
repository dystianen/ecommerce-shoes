<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('CategorySeeder');
        $this->call('SizeSeeder');
        $this->call('BrandSeeder');
    }
}
