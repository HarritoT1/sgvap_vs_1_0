<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
