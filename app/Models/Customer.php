<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
	use HasFactory;

	protected $table = 'customers';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'id',
		'razon_social',
		'ubicacion',
		'status',
	];

	public function projects()
	{
		return $this->hasMany(Project::class);
	}
}
