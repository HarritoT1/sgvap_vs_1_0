<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExtraEcoreDebt
 * 
 * @property int $id
 * @property float $monto_extra_ecore
 * @property string $campo_descontar
 * @property Carbon $fecha_descontar
 * @property string $status
 * @property Carbon $last_update
 * @property string|null $employee_id
 * 
 * @property Employee|null $employee
 *
 * @package App\Models
 */
class ExtraEcoreDebt extends Model
{
	protected $table = 'extra_ecore_debts';
	public $timestamps = false;

	protected $casts = [
		'monto_extra_ecore' => 'float',
		'fecha_descontar' => 'datetime',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'monto_extra_ecore',
		'campo_descontar',
		'fecha_descontar',
		'status',
		'last_update',
		'employee_id'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
