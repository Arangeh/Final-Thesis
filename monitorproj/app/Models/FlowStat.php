<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowStat extends Model
{
	use HasFactory;
	protected $table = 'flowstats';
	public $timestamps = false;
}
