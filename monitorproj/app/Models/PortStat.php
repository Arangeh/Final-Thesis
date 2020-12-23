<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PortStat extends Model
{
	use HasFactory;
	protected $table = 'portstats';
	public $timestamps = false;
}
