<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * 
 * @property string $id
 * @property string $razon_social
 * @property string $ubicacion
 * @property string $status
 * @property Carbon $last_update
 * 
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customers';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'razon_social',
		'ubicacion',
		'status',
		'last_update'
	];

	public function projects()
	{
		return $this->hasMany(Project::class);
	}
}
