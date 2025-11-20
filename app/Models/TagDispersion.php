<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * Class TagDispersion
 * 
 * @property int $id
 * @property Carbon $fecha_dispersion
 * @property string|null $project_id
 * @property string|null $vehicle_id
 * @property string $nombre_caseta
 * @property float $base_imponible
 * @property float $iva_caseta
 * @property float $importe_total
 * @property Carbon $last_update
 * 
 * @property Project|null $project
 * @property Vehicle|null $vehicle
 *
 * @package App\Models
 */
class TagDispersion extends Model
{
	use HasFactory;

	protected $table = 'tag_dispersions';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'fecha_dispersion' => 'datetime',
		'base_imponible' => 'float',
		'iva_caseta' => 'float',
		'importe_total' => 'float',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'fecha_dispersion',
		'project_id',
		'vehicle_id',
		'nombre_caseta',
		'base_imponible',
		'iva_caseta',
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

	public static function tag_for_project($mes = null, $year = null, $projectId = null, $proyects_inactive = false)
	{
		//Si el usuario manda projectId, NO debes filtrar activos/inactivos. Nunca.

		//Porque si el usuario pide un proyecto específico, tiene sentido devolverlo independientemente de su estado.

		$caseta_por_proyecto = self::select(
			'projects.id AS project_id',
			'projects.nombre AS project_name',
			'projects.status AS project_status',
			DB::raw('SUM(tag_dispersions.importe_total) AS total_invertido_caseta')
		)
			->join('projects', 'tag_dispersions.project_id', '=', 'projects.id')
			->when($mes, fn($q) => $q->whereMonth('tag_dispersions.fecha_dispersion', $mes))
			->when($year, fn($q) => $q->whereYear('tag_dispersions.fecha_dispersion', $year))
			->when($projectId, fn($q) => $q->where('tag_dispersions.project_id', $projectId))
			->groupBy('projects.id', 'projects.nombre', 'projects.status')
			->get();

		// Ajuste correcto:
		if (!$proyects_inactive && !$projectId) {
			return $caseta_por_proyecto->where('project_status', 'activo');
		}

		return $caseta_por_proyecto;
	}

	public static function tag_for_vehicle($mes = null, $year = null, $projectId = null, $vehicleId = null, $proyects_inactive = false)
	{
		//Si el usuario manda projectId, NO debes filtrar activos/inactivos. Nunca.

		//Porque si el usuario pide un proyecto específico, tiene sentido devolverlo independientemente de su estado.

		$caseta_por_vehiculo = self::select(
			'vehicles.id AS vehicle_id',
			DB::raw('SUM(tag_dispersions.importe_total) AS total_invertido_caseta')
		)
			->join('vehicles', 'tag_dispersions.vehicle_id', '=', 'vehicles.id')
			->join('projects', 'tag_dispersions.project_id', '=', 'projects.id')
			->when($mes, fn($q) => $q->whereMonth('tag_dispersions.fecha_dispersion', $mes))
			->when($year, fn($q) => $q->whereYear('tag_dispersions.fecha_dispersion', $year))
			->when($projectId, fn($q) => $q->where('tag_dispersions.project_id', $projectId))
			->when($vehicleId, fn($q) => $q->where('tag_dispersions.vehicle_id', $vehicleId))
			->when(
				!$proyects_inactive && !$projectId,
				fn($q) =>
				$q->where('projects.status', 'activo')
			)

			->groupBy('vehicles.id')
			->get();

		return $caseta_por_vehiculo;
	}
}
