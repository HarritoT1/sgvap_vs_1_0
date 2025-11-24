<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VehicleLoan
 * 
 * @property int $id
 * @property string|null $employee_id
 * @property string $proveedor
 * @property string|null $project_id
 * @property string|null $vehicle_id
 * @property Carbon $fecha_prestamo
 * @property Carbon|null $fecha_devolucion
 * @property string $status
 * @property int $km_salida
 * @property int|null $km_retorno
 * @property string|null $ruta_evidencia_1
 * @property string|null $ruta_evidencia_2
 * @property string|null $ruta_evidencia_3
 * @property string|null $ruta_evidencia_4
 * @property string|null $ruta_evidencia_5
 * @property string|null $obs_gral
 * @property Carbon $last_update
 * 
 * @property Employee|null $employee
 * @property Project|null $project
 * @property Vehicle|null $vehicle
 *
 * @package App\Models
 */
class VehicleLoan extends Model
{	
	use HasFactory;

	protected $table = 'vehicle_loans';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'fecha_prestamo' => 'datetime',
		'fecha_devolucion' => 'datetime',
		'km_salida' => 'int',
		'km_retorno' => 'int',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'employee_id',
		'proveedor',
		'project_id',
		'vehicle_id',
		'fecha_prestamo',
		'fecha_devolucion',
		'status',
		'km_salida',
		'km_retorno',
		'ruta_evidencia_1',
		'ruta_evidencia_2',
		'ruta_evidencia_3',
		'ruta_evidencia_4',
		'ruta_evidencia_5',
		'obs_gral',
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}
}
