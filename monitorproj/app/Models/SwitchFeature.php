<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchFeature extends Model
{
	use HasFactory;
	protected $table = 'switch_features';
	protected $fillable = ['datapath_id'];
	public $timestamps = false;
}
