<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MonthlyExpenseCut
 * 
 * @property int $id
 * @property int $mes
 * @property int $anio
 * @property float|null $total_alimentos_mes
 * @property float|null $total_traslado_local_mes
 * @property float|null $total_traslado_externo_mes
 * @property float|null $total_comision_bancaria_mes
 * @property float|null $total_comision_sivale_mes
 * @property float|null $total_iva_mes
 * @property Carbon $last_update
 * @property string|null $employee_id
 * 
 * @property Employee|null $employee
 *
 * @package App\Models
 */
class MonthlyExpenseCut extends Model
{
	protected $table = 'monthly_expense_cuts';
	public $timestamps = false;

	protected $casts = [
		'mes' => 'int',
		'anio' => 'int',
		'total_alimentos_mes' => 'float',
		'total_traslado_local_mes' => 'float',
		'total_traslado_externo_mes' => 'float',
		'total_comision_bancaria_mes' => 'float',
		'total_comision_sivale_mes' => 'float',
		'total_iva_mes' => 'float',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'mes',
		'anio',
		'total_alimentos_mes',
		'total_traslado_local_mes',
		'total_traslado_externo_mes',
		'total_comision_bancaria_mes',
		'total_comision_sivale_mes',
		'total_iva_mes',
		'last_update',
		'employee_id'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
