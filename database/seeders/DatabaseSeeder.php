<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Modules\AppModule\Database\Seeders\AppModuleSeeder;
use App\Modules\Company\Database\Seeders\CompanySeeder;
use App\Modules\CompanyType\Database\Seeders\CompanyTypeSeeder;
use App\Modules\Country\Database\Seeders\CountrySeeder;
use App\Modules\Currency\Database\Seeders\CurrencySeeder;
use App\Modules\Department\Database\Seeders\DepartmentSeeder;
use App\Modules\Designation\Database\Seeders\DesignationSeeder;
use App\Modules\EmployeeGroup\Database\Seeders\EmployeeGroupSeeder;
use App\Modules\FiscalYear\Database\Seeders\FiscalYearSeeder;
use App\Modules\Grade\Database\Seeders\GradeSeeder;
use App\Modules\Role\Database\Seeders\RoleSeeder;
use App\Modules\State\Database\Seeders\StateSeeder;
use App\Modules\TopicCategory\Database\Seeders\TopicCategorySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                // TopicCategorySeeder::class
            AppModuleSeeder::class,
            RoleSeeder::class,

            CurrencySeeder::class,
            CountrySeeder::class,
            StateSeeder::class,

            FiscalYearSeeder::class,
            CompanyTypeSeeder::class,
            CompanySeeder::class,
            SampleDataSeeder::class,


            DepartmentSeeder::class,
            DesignationSeeder::class,
            GradeSeeder::class,
                // ShiftSeeder::class,

                // VoucherSeeder::class,
                // VoucherEntrySeeder::class,

            EmployeeGroupSeeder::class,
        ]);

    }
}
