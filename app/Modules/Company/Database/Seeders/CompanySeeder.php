<?php

namespace App\Modules\Company\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Company\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Taxyaar Solutions Pvt Ltd',
            'code' => 'C001',
            'mailing_name' => 'Taxyaar Solutions Pvt Ltd',
            'address' => 'N.H.-34, MangalBari, Malda',
            'phone_no' => '03512-00022',
            'mobile_no' => '8551495288',
            'email' => 'sharma_hardware@gmail.com',
            'website' => 'www.taxyaar.com',
            'company_type_id' => 1,
            'cin_no' => '1234567890',
            'tin_no' => '1234567890',
            'tan_no' => '1234567890',
            'gst_no' => 'sss',
            'pan_no' => '1234567890',
            'logo' => 'logo.png',
            'currency_id' => 1,
            'country_id' => 76,
            'state_id' => 36,
            'city' => 'Behala',
            'zip_code' => '705587',
            'status' => 'active',
        ]);

        // Uncomment to use factory if available
        // Company::factory()->count(10)->create();
    }
}
