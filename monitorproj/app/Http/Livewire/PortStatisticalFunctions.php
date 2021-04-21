<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PortStat;
use App\Models\FlowStat;

class PortStatisticalFunctions extends Component
{
	public $selectedPortDP = null;
	
	// public $selectedPort = null;
	public $selectedPort = null;
	public $ports = null;

	// public $uniqueDP = null;
	public $partialPortstats = null;
	// Statistical functions applied on tx_pkts
	public $tx_pkts_avg;
	public $tx_pkts_std;
	public $tx_pkts_min;
	public $tx_pkts_max;
	// Statistical functions applied on tx_bytes
	public $tx_bytes_avg;
	public $tx_bytes_std;
	public $tx_bytes_min;
	public $tx_bytes_max;
	// Statistical functions applied on tx_error
	public $tx_error_avg;
	public $tx_error_std;
	public $tx_error_min;
	public $tx_error_max;
	// Statistical functions applied on rx_pkts
	public $rx_pkts_avg;
	public $rx_pkts_std;
	public $rx_pkts_min;
	public $rx_pkts_max;
	// Statistical functions applied on rx_bytes
	public $rx_bytes_avg;
	public $rx_bytes_std;
	public $rx_bytes_min;
	public $rx_bytes_max;
	// Statistical functions applied on rx_error
	public $rx_error_avg;
	public $rx_error_std;
	public $rx_error_min;
	public $rx_error_max;

	// public $selectedPortDP = null;
	
	// public $selectedPort = null;
	// public $selectedPort = null;
	// public $ports = null;

	// public $uniqueDP = null;
	// public $partialPortstats = null;

	public function updatedSelectedPort($s_port)
	{
		$this->partialPortstats = Portstat::where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		// for tx_pkts
		$this->tx_pkts_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_pkts) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();

		// $this->tx_pkts_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_pkts) as kos'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->first();
		// $this->tx_pkts_std = $this->tx_pkts_std -> ;
		// $this->tx_pkts_std = gettype($this->tx_pkts_std);
		$this->tx_pkts_avg = $this->partialPortstats->avg('tx_pkts');
		$this->tx_pkts_min = $this->partialPortstats->min('tx_pkts');
		$this->tx_pkts_max = $this->partialPortstats->max('tx_pkts');
		// for tx_bytes
		// $this->tx_bytes_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_bytes)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->tx_bytes_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_bytes) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->tx_bytes_avg = $this->partialPortstats->avg('tx_bytes');
		$this->tx_bytes_min = $this->partialPortstats->min('tx_bytes');
		$this->tx_bytes_max = $this->partialPortstats->max('tx_bytes');
		// for tx_error
		// $this->tx_error_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_error)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->tx_error_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_error) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->tx_error_avg = $this->partialPortstats->avg('tx_error');
		$this->tx_error_min = $this->partialPortstats->min('tx_error');
		$this->tx_error_max = $this->partialPortstats->max('tx_error');
		// for rx_pkts
		// $this->rx_pkts_std = DB::table('portstats')->select(DB::raw('STDDEV(rx_pkts)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_pkts_std = DB::table('portstats')->select(DB::raw('STDDEV(rx_pkts) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_pkts_avg = $this->partialPortstats->avg('rx_pkts');
		$this->rx_pkts_min = $this->partialPortstats->min('rx_pkts');
		$this->rx_pkts_max = $this->partialPortstats->max('rx_pkts');
		// for rx_bytes
		// $this->rx_bytes_avg = DB::table('portstats')->select(DB::raw('STDDEV(rx_bytes)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_bytes_std = DB::table('portstats')->select(DB::raw('STDDEV(rx_bytes) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_bytes_avg = $this->partialPortstats->avg('rx_bytes');
		$this->rx_bytes_min = $this->partialPortstats->min('rx_bytes');
		$this->rx_bytes_max = $this->partialPortstats->max('rx_bytes');
		// for rx_error
		// $this->rx_error_avg = DB::table('portstats')->select(DB::raw('STDDEV(tx_pkts)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_error_std = DB::table('portstats')->select(DB::raw('STDDEV(rx_error) as std'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		$this->rx_error_avg = $this->partialPortstats->avg('rx_error');
		$this->rx_error_min = $this->partialPortstats->min('rx_error');
		$this->rx_error_max = $this->partialPortstats->max('rx_error');
	}
	

	public function updatedSelectedPortDP($dpid)
	{

		// $this-> ports = PortStat::where('datapath', $dp)->distinct('port')->get();
		// $portstats=PortStat::where('datapath', $dp)
		// $this-> uniquePorts = DB::table('portstats')->where('datapath','=',$dp)->groupBy('port');
		// $this->ports = DB::table('portstats')->select('port')->where('datapath',$dpid)->groupBy('port')->get();
		
		$this->ports = PortStat::select('port')->groupBy('port')->where('datapath',$dpid)->get();
		// $this->uniquePorts = ($this->ports)->groupBy('datapath')
		// $this->ports=PortStat::all();
	}	
	public function render()
	{
		$portstats = PortStat::all();
		$uniqueDP = $portstats->unique('datapath');
		$data = array('portstats' => $portstats,
		'uniqueDP' => $uniqueDP);
		return view('livewire.port-statistical-functions')
			->with($data);
	}
}
