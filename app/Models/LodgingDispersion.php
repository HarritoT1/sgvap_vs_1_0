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
 * Class LodgingDispersion
 * 
 * @property int $id
 * @property Carbon $fecha_dispersion
 * @property string|null $project_id
 * @property string $rfc_hospedaje
 * @property string $razon_social
 * @property int $numero_noches
 * @property float $costo_x_noche
 * @property int $numero_personas
 * @property float $base_imponible
 * @property float $iva_hospedaje
 * @property float $importe_total
 * @property Carbon $last_update
 * 
 * @property Project|null $project
 *
 * @package App\Models
 */
class LodgingDispersion extends Model
{
	use HasFactory;

	protected $table = 'lodging_dispersions';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'fecha_dispersion' => 'datetime',
		'numero_noches' => 'int',
		'costo_x_noche' => 'float',
		'numero_personas' => 'int',
		'base_imponible' => 'float',
		'iva_hospedaje' => 'float',
		'importe_total' => 'float',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'fecha_dispersion',
		'project_id',
		'rfc_hospedaje',
		'razon_social',
		'numero_noches',
		'costo_x_noche',
		'numero_personas',
		'base_imponible',
		'iva_hospedaje',
		'importe_total',
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public static function lodging_for_project($mes = null, $year = null, $projectId = null, $proyects_inactive = false)
	{
		//Si el usuario manda projectId, NO debes filtrar activos/inactivos. Nunca.

		//Porque si el usuario pide un proyecto específico, tiene sentido devolverlo independientemente de su estado.

		$hospedaje_por_proyecto = self::select(
			'projects.id AS project_id',
			'projects.nombre AS project_name',
			'projects.status AS project_status',
			DB::raw('SUM(lodging_dispersions.importe_total) AS total_invertido_hospedaje')
		)
			->join('projects', 'lodging_dispersions.project_id', '=', 'projects.id')
			->when($mes, fn($q) => $q->whereMonth('lodging_dispersions.fecha_dispersion', $mes))
			->when($year, fn($q) => $q->whereYear('lodging_dispersions.fecha_dispersion', $year))
			->when($projectId, fn($q) => $q->where('lodging_dispersions.project_id', $projectId))
			->groupBy('projects.id', 'projects.nombre', 'projects.status')
			->get();

		// Ajuste correcto:
		if (!$proyects_inactive && !$projectId) {
			return $hospedaje_por_proyecto->where('project_status', 'activo');
		}

		return $hospedaje_por_proyecto;
	}
}
