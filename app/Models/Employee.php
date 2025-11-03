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
 * Class Employee
 * 
 * @property string $id
 * @property string $nombre
 * @property string $puesto
 * @property string $status
 * @property string $modo
 * @property Carbon $last_update
 * 
 * @property Collection|DailyExpenseReport[] $daily_expense_reports
 * @property Collection|ExtraEcoreDebt[] $extra_ecore_debts
 * @property Collection|MonthlyExpenseCut[] $monthly_expense_cuts
 * @property Collection|VehicleLoan[] $vehicle_loans
 *
 * @package App\Models
 */
class Employee extends Model
{
	use HasFactory;

	protected $table = 'employees';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'last_update' => 'datetime'
	];

	protected $fillable = [
		'id',
		'nombre',
		'puesto',
		'status',
		'modo',
	];

	public function daily_expense_reports()
	{
		return $this->hasMany(DailyExpenseReport::class);
	}

	public function extra_ecore_debts()
	{
		return $this->hasMany(ExtraEcoreDebt::class);
	}

	public function monthly_expense_cuts()
	{
		return $this->hasMany(MonthlyExpenseCut::class);
	}

	public function vehicle_loans()
	{
		return $this->hasMany(VehicleLoan::class);
	}
}
