<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
	use HasFactory;

	protected $table = 'gasoline_dispersions';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
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
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	public static function gas_for_project($mes = null, $year = null, $projectId = null, $proyects_inactive = false)
	{
		//Si el usuario manda projectId, NO debes filtrar activos/inactivos. Nunca.

		//Porque si el usuario pide un proyecto específico, tiene sentido devolverlo independientemente de su estado.

		$gasolina_por_proyecto = self::select(
			'projects.id AS project_id',
			'projects.nombre AS project_name',
			'projects.status AS project_status',
			DB::raw('SUM(gasoline_dispersions.importe_total) AS total_invertido_gasolina')
		)
			->join('projects', 'gasoline_dispersions.project_id', '=', 'projects.id')
			->when($mes, fn($q) => $q->whereMonth('gasoline_dispersions.fecha_dispersion', $mes))
			->when($year, fn($q) => $q->whereYear('gasoline_dispersions.fecha_dispersion', $year))
			->when($projectId, fn($q) => $q->where('gasoline_dispersions.project_id', $projectId))
			->groupBy('projects.id', 'projects.nombre', 'projects.status')
			->get();

		// Ajuste correcto:
		if (!$proyects_inactive && !$projectId) {
			return $gasolina_por_proyecto->where('project_status', 'activo');
		}

		return $gasolina_por_proyecto;
	}

	public static function gas_for_vehicle($mes = null, $year = null, $projectId = null, $vehicleId = null, $proyects_inactive = false)
	{
		//Si el usuario manda projectId, NO debes filtrar activos/inactivos. Nunca.

		//Porque si el usuario pide un proyecto específico, tiene sentido devolverlo independientemente de su estado.

		$gasolina_por_vehiculo = self::select(
			'vehicles.id AS vehicle_id',
			DB::raw('SUM(gasoline_dispersions.importe_total) AS total_invertido_gasolina')
		)
			->join('vehicles', 'gasoline_dispersions.vehicle_id', '=', 'vehicles.id')
			->join('projects', 'gasoline_dispersions.project_id', '=', 'projects.id')
			->when($mes, fn($q) => $q->whereMonth('gasoline_dispersions.fecha_dispersion', $mes))
			->when($year, fn($q) => $q->whereYear('gasoline_dispersions.fecha_dispersion', $year))
			->when($projectId, fn($q) => $q->where('gasoline_dispersions.project_id', $projectId))
			->when($vehicleId, fn($q) => $q->where('gasoline_dispersions.vehicle_id', $vehicleId))
			->when(
				!$proyects_inactive && !$projectId,
				fn($q) =>
				$q->where('projects.status', 'activo')
			)

			->groupBy('vehicles.id')
			->get();

		return $gasolina_por_vehiculo;
	}
}
