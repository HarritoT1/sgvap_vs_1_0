<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property string $id
 * @property string|null $customer_id
 * @property string $nombre
 * @property string $sitio
 * @property float $monto_cobrar
 * @property float|null $monto_est_vtc_alimentos
 * @property float|null $monto_est_vtc_tras_local
 * @property float|null $monto_est_vtc_tras_externo
 * @property float|null $monto_est_vtc_com_bancaria
 * @property float|null $monto_est_vtc_gasolina
 * @property float|null $monto_est_vtc_caseta
 * @property float|null $monto_est_vtc_hospedaje
 * @property float $estimado_viaticos
 * @property string $estimado_tiempo
 * @property Carbon $fecha_limite
 * @property string|null $notas
 * @property string $status
 * @property Carbon $fecha_creacion
 * @property Carbon $last_update
 * 
 * @property Customer|null $customer
 * @property Collection|DailyExpenseReport[] $daily_expense_reports
 * @property Collection|GasolineDispersion[] $gasoline_dispersions
 * @property Collection|LodgingDispersion[] $lodging_dispersions
 * @property Collection|TagDispersion[] $tag_dispersions
 * @property Collection|VehicleLoan[] $vehicle_loans
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'projects';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'monto_cobrar' => 'float',
		'monto_est_vtc_alimentos' => 'float',
		'monto_est_vtc_tras_local' => 'float',
		'monto_est_vtc_tras_externo' => 'float',
		'monto_est_vtc_com_bancaria' => 'float',
		'monto_est_vtc_gasolina' => 'float',
		'monto_est_vtc_caseta' => 'float',
		'monto_est_vtc_hospedaje' => 'float',
		'estimado_viaticos' => 'float',
		'fecha_limite' => 'datetime',
		'fecha_creacion' => 'datetime',
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'customer_id',
		'nombre',
		'sitio',
		'monto_cobrar',
		'monto_est_vtc_alimentos',
		'monto_est_vtc_tras_local',
		'monto_est_vtc_tras_externo',
		'monto_est_vtc_com_bancaria',
		'monto_est_vtc_gasolina',
		'monto_est_vtc_caseta',
		'monto_est_vtc_hospedaje',
		'estimado_viaticos',
		'estimado_tiempo',
		'fecha_limite',
		'notas',
		'status',
		'fecha_creacion',
		'last_update'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function daily_expense_reports()
	{
		return $this->hasMany(DailyExpenseReport::class);
	}

	public function gasoline_dispersions()
	{
		return $this->hasMany(GasolineDispersion::class);
	}

	public function lodging_dispersions()
	{
		return $this->hasMany(LodgingDispersion::class);
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
