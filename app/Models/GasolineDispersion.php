<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GasolineDispersion
 * 
 * @property int $id
 * @property Carbon $fecha_dispersion
 * @property string|null $project_id
 * @property string|null $vehicle_id
 * @property float $costo_lt
 * @property float $cant_litros
 * @property float $monto_dispersado
 * @property float $base_imponible
 * @property float $iva_acumulado
 * @property float $importe_total
 * @property Carbon $last_update
 * 
 * @property Project|null $project
 * @property Vehicle|null $vehicle
 *
 * @package App\Models
 */
class GasolineDispersion extends Model
{
	protected $table = 'gasoline_dispersions';
	public $timestamps = false;

	protected $casts = [
		'fecha_dispersion' => 'datetime',
		'costo_lt' => 'float',
		'cant_litros' => 'float',
		'monto_dispersado' => 'float',
		'base_imponible' => 'float',
		'iva_acumulado' => 'float',
		'importe_total' => 'float',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'fecha_dispersion',
		'project_id',
		'vehicle_id',
		'costo_lt',
		'cant_litros',
		'monto_dispersado',
		'base_imponible',
		'iva_acumulado',
		'importe_total',
		'last_update'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}
}
