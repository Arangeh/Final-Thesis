<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchID extends Model
{
	use HasFactory;
	protected $table = 'switch_id_s';
	protected $fillable = ['datapath'];
	public $timestamps = false;
}
