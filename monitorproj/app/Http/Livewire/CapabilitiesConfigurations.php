<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\SwitchDescription;
use App\Models\SwitchFeature;
use App\Models\SwitchFlow;
use App\Models\SwitchPortDescription;
use App\Models\SwitchTable;
use App\Models\SwitchID;

class CapabilitiesConfigurations extends Component
{
	/*
	public $packets_avg;
	public $packets_std;
	public $packets_min;
	public $packets_max;
	// Statistical functions applied on bytes
	public $bytes_avg;
	public $bytes_std;
	public $bytes_min;
	public $bytes_max;
	*/
	public $selectedDP = null;
	
	public $ports = null;
	public $flows = null;
	public $tables = null; 
	public $mfr_desc = null;
	public $n_buffers = null;
	public $n_tables = null;
	public $hw_desc = null;
	public $sw_desc = null;
	public $capabilities = null;

	public function updatedSelectedDP($dpid)
	{
		$this->flows = SwitchFlow::where('datapath',$dpid)->get();
		$this->ports = SwitchPortDescription::where('datapath',$dpid)->get();
		$this->tables = SwitchTable::where('datapath',$dpid)->get();
		$swdescription = SwitchDescription::where('datapath',$dpid)->first();
		//$this-> mfr_desc = SwitchDescription::all();
		$this-> mfr_desc = $swdescription -> mfr_desc;
		$this-> hw_desc = $swdescription -> hw_desc;
		$this-> sw_desc = $swdescription -> sw_desc;
		$swfeatures = SwitchFeature::where('datapath_id',$dpid)->first();
		$this-> n_buffers = $swfeatures -> n_buffers;
		$this-> n_tables = $swfeatures -> n_tables;
		$this-> capabilities = $swfeatures -> capabilities;
	}

	public function render()
	{
		$datapaths = SwitchID::all();
		return view('livewire.capabilities-configurations')->with('datapaths',$datapaths);
	}
}
