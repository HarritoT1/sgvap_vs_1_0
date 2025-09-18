<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * 
 * @property string $id
 * @property string $nombre_modelo
 * @property string $marca
 * @property int $anio
 * @property string $color
 * @property string|null $ruta_foto_1
 * @property int $km_actual
 * @property string|null $obs_gral
 * @property string $status
 * @property bool $is_on_loan
 * @property string|null $caracteristicas
 * @property Carbon $last_update
 * 
 * @property Collection|GasolineDispersion[] $gasoline_dispersions
 * @property Collection|TagDispersion[] $tag_dispersions
 * @property Collection|VehicleLoan[] $vehicle_loans
 *
 * @package App\Models
 */
class Vehicle extends Model
{
	protected $table = 'vehicles';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'anio' => 'int',
		'km_actual' => 'int',
		'is_on_loan' => 'bool',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'nombre_modelo',
		'marca',
		'anio',
		'color',
		'ruta_foto_1',
		'km_actual',
		'obs_gral',
		'status',
		'is_on_loan',
		'caracteristicas',
		'last_update'
	];

	public function gasoline_dispersions()
	{
		return $this->hasMany(GasolineDispersion::class);
	}

	public function tag_dispersions()
	{
		return $this->hasMany(TagDispersion::class);
	}

	public function vehicle_loans()
	{
		return $this->hasMany(VehicleLoan::class);
	}
}
