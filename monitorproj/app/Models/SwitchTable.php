<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchTable extends Model
{
	use HasFactory;
	protected $table = 'switch_tables';
	protected $fillable = ['datapath', 'table_id'];
	public $timestamps = false;
}
