<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DailyExpenseReport
 * 
 * @property int $id
 * @property Carbon $fecha_dispersion_dia
 * @property float|null $desayuno
 * @property float|null $comida
 * @property float|null $cena
 * @property float|null $traslado_local
 * @property float|null $traslado_externo
 * @property float|null $comision_bancaria
 * @property Carbon $last_update
 * @property string|null $employee_id
 * @property string|null $project_id
 * 
 * @property Employee|null $employee
 * @property Project|null $project
 *
 * @package App\Models
 */
class DailyExpenseReport extends Model
{
	protected $table = 'daily_expense_reports';
	public $timestamps = false;

	protected $casts = [
		'fecha_dispersion_dia' => 'datetime',
		'desayuno' => 'float',
		'comida' => 'float',
		'cena' => 'float',
		'traslado_local' => 'float',
		'traslado_externo' => 'float',
		'comision_bancaria' => 'float',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'fecha_dispersion_dia',
		'desayuno',
		'comida',
		'cena',
		'traslado_local',
		'traslado_externo',
		'comision_bancaria',
		'last_update',
		'employee_id',
		'project_id'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
