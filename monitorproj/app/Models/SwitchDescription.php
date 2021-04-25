<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchDescription extends Model
{
	use HasFactory;
	protected $table = 'switch_descriptions';
	protected $fillable = ['datapath'];
	public $timestamps = false;
}
