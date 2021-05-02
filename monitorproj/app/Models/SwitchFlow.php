<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchFlow extends Model
{
	use HasFactory;
	protected $table = 'switch_flows';
	protected $fillable = ['datapath', 'table_id', 'flow_id'];
	public $timestamps = false;
}
