<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CompanyProfile::create([
            'company_name'      => 'NITCorp',
            'company_address'   => 'Gandaria 8 Office Tower, 7th floor. Unit I-J, Jl. Sultan Iskandar Muda, RT.10/RW.6, North Kebayoran Lama, Jakarta, South Jakarta City, Jakarta 12240',
            'company_phone'     => '082817080221'
        ]);
    }
}
