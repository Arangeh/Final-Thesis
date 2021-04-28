<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchPortDescription extends Model
{
	use HasFactory;
	protected $table = 'switch_port_descriptions';
	protected $fillable = ['hw_addr'];
	public $timestamps = false;
}
