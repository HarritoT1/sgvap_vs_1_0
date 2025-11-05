<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->truncateTables(['customers', 'projects', 'employees', 'daily_expense_reports', 'extra_ecore_debts', 'gasoline_dispersions', 'lodging_dispersions', 'tag_dispersions']);
        $this->call(CustomerSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(DailyExpenseReportSeeder::class);
        $this->call(ExtraEcoreDebtSeeder::class);
        $this->call(GasolineDispersionSeeder::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
