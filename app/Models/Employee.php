<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * Class Employee
 * 
 * @property string $id
 * @property string $nombre
 * @property string $puesto
 * @property string $status
 * @property string $modo
 * @property Carbon $last_update
 * 
 * @property Collection|DailyExpenseReport[] $daily_expense_reports
 * @property Collection|ExtraEcoreDebt[] $extra_ecore_debts
 * @property Collection|MonthlyExpenseCut[] $monthly_expense_cuts
 * @property Collection|VehicleLoan[] $vehicle_loans
 *
 * @package App\Models
 */
class Employee extends Model
{
	use HasFactory;

	protected $table = 'employees';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'id',
		'nombre',
		'puesto',
		'status',
		'modo',
	];

	public function daily_expense_reports()
	{
		return $this->hasMany(DailyExpenseReport::class);
	}

	public function extra_ecore_debts()
	{
		return $this->hasMany(ExtraEcoreDebt::class);
	}

	public function monthly_expense_cuts()
	{
		return $this->hasMany(MonthlyExpenseCut::class);
	}

	public function vehicle_loans()
	{
		return $this->hasMany(VehicleLoan::class);
	}

	public static function generate_data_graphics_vts($mes = null, $year = null, $projectId = null, $rfc = null)
	{
		$viaticos_por_empleado = self::select(
			'employees.id',
			'employees.nombre AS nombre',
			DB::raw('SUM(COALESCE(daily_expense_reports.desayuno, 0) + COALESCE(daily_expense_reports.comida, 0) + COALESCE(daily_expense_reports.cena, 0)) AS total_alimentos'),
			DB::raw('SUM(daily_expense_reports.traslado_local) AS total_traslado_local'),
			DB::raw('SUM(daily_expense_reports.traslado_externo) AS total_traslado_externo'),
			DB::raw('SUM(daily_expense_reports.comision_bancaria) AS total_comision_bancaria')
		)
			->join('daily_expense_reports', 'daily_expense_reports.employee_id', '=', 'employees.id')
			->when($mes, fn($q) => $q->whereMonth('daily_expense_reports.fecha_dispersion_dia', $mes))
			->when($year, fn($q) => $q->whereYear('daily_expense_reports.fecha_dispersion_dia', $year))
			->when($projectId, fn($q) => $q->where('daily_expense_reports.project_id', $projectId))
			->when($rfc, fn($q) => $q->where('daily_expense_reports.employee_id', $rfc))
			->groupBy('employees.id', 'employees.nombre')
			->get();

		return $viaticos_por_empleado;
	}

	public static function generate_data_alimentos_pie_graphic($mes = 0, $personnel_inactive = false)
	{
		$data_alimentos = collect(DB::select('graf_pastel_vtc_alimento(?)', [$mes]));

		if (!$personnel_inactive) return $data_alimentos->where('status', 'activo');

		return $data_alimentos;
	}

	public static function generate_data_tras_local_pie_graphic($mes = 0, $personnel_inactive = false)
	{
		$data_tras_local = collect(DB::select('graf_pastel_vtc_traslado_local(?)', [$mes]));

		if (!$personnel_inactive) return $data_tras_local->where('status', 'activo');

		return $data_tras_local;
	}

	public static function generate_data_tras_externo_pie_graphic($mes = 0, $personnel_inactive = false)
	{
		$data_tras_externo = collect(DB::select('graf_pastel_vtc_traslado_externo(?)', [$mes]));

		if (!$personnel_inactive) return $data_tras_externo->where('status', 'activo');

		return $data_tras_externo;
	}

	public static function generate_data_com_bancaria_pie_graphic($mes = 0, $personnel_inactive = false)
	{
		$data_com_bancaria = collect(DB::select('graf_pastel_vtc_com_bancaria(?)', [$mes]));

		if (!$personnel_inactive) return $data_com_bancaria->where('status', 'activo');

		return $data_com_bancaria;
	}
}
