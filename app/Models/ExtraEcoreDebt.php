<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
	use HasFactory;

	protected $table = 'extra_ecore_debts';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'monto_extra_ecore' => 'float',
		'fecha_descontar' => 'datetime',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'monto_extra_ecore',
		'campo_descontar',
		'fecha_descontar',
		'status',
		'employee_id'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
