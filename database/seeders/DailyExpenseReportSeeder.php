<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DailyExpenseReport;
use App\Models\Employee;
use App\Models\Project;

class DailyExpenseReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener 5 ids de empleados aleatorios únicos.
        $arrayEmployeeIds = Employee::inRandomOrder()->limit(5)->pluck('id')->toArray();
        // Obtener 5 ids de proyectos aleatorios únicos.
        $arrayProjectIds = Project::inRandomOrder()->limit(5)->pluck('id')->toArray();
        $i = 0;

        foreach ($arrayEmployeeIds as $employeeId) {
            DailyExpenseReport::factory()->count(10)->create([
                'employee_id' => $employeeId, 'project_id' => $arrayProjectIds[$i],
            ]);

            $i++;
        }
    }
}
