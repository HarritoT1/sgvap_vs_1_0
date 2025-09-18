<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
	protected $table = 'lodging_dispersions';
	public $timestamps = false;

	protected $casts = [
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
		'last_update'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
