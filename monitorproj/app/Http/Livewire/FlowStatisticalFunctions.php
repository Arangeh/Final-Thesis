<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\FlowStat;

class FlowStatisticalFunctions extends Component
{

	public $selectedFlowDP = null;
	public $selectedInputPort = null;
	public $selectedOutputPort = null;
	public $selectedEthernetDestination = null;
	// PartialFlowstats are created by these filters applied in order
	// 1-datapath
	// 2-in_port
	// 3-out_port
	// 4-eth_dst
	public $partialFlowstatsInPort = null;
	public $partialFlowstatsOutPort = null;
	public $partialFlowstatsEthDst = null;

	
	public $flowsInPort = null;
	public $flowsOutPort = null;
	public $flowsEthDst = null;
	
	// Statistical functions applied on packets
	public $packets_avg;
	public $packets_std;
	public $packets_min;
	public $packets_max;
	// Statistical functions applied on bytes
	public $bytes_avg;
	public $bytes_std;
	public $bytes_min;
	public $bytes_max;
	public function updatedSelectedFlowDP($dpid)
	{
		$this->flowsInPort = FlowStat::select('in_port')->groupBy('in_port')
		->where('datapath',$dpid)->get();
	}
	public function updatedSelectedInputPort($input_port)
	{
		$this->flowsOutPort = FlowStat::select('out_port')->groupBy('out_port')
		->where('datapath', $this->selectedFlowDP)
		->where('in_port',$input_port)
		->get();
		// $this->partialFlowstatsInPort = Flowstat::where('datapath', $this->selectedFlowDP)
		// ->where('in_port',$input_port)
		// ->get();
	}
	public function updatedSelectedOutputPort($output_port)
	{
		$this->flowsEthDst = FlowStat::select('eth_dst')->groupBy('eth_dst')
		->where('datapath', $this->selectedFlowDP)
		->where('in_port',$this->selectedInputPort)
		->where('out_port',$output_port)
		->get();
		// $this->partialFlowstatsOutPort = Flowstat::where('datapath', $this->selectedFlowDP)
		// ->where('in_port',$this->selectedInputPort)
		// ->where('out_port',$output_port)
		// ->get();
	}

	public function updatedSelectedEthernetDestination($ethernet_destination)
	{
	
		$this->partialFlowstatsEthDst = Flowstat::where('datapath', $this->selectedFlowDP)
		->where('in_port',$this->selectedInputPort)
		->where('out_port',$this->selectedOutputPort)
		->where('eth_dst',$ethernet_destination)
		->get();
		
		$this->packets_std = DB::table('flowstats')->
		select(DB::raw('STDDEV(packets) as std'))
		->where('datapath', $this->selectedFlowDP)
		->where('in_port',$this->selectedInputPort)
		->where('out_port',$this->selectedOutputPort)
		->where('eth_dst',$ethernet_destination)
		->get();
		$this->packets_avg = $this->partialFlowstatsEthDst->avg('packets');
		$this->packets_min = $this->partialFlowstatsEthDst->min('packets');
		$this->packets_max = $this->partialFlowstatsEthDst->max('packets');

		$this->bytes_std = DB::table('flowstats')->select(DB::raw('STDDEV(bytes) as std'))
		->where('datapath', $this->selectedFlowDP)
		->where('in_port',$this->selectedInputPort)
		->where('out_port',$this->selectedOutputPort)
		->where('eth_dst',$ethernet_destination)
		->get();
		$this->bytes_avg = $this->partialFlowstatsEthDst->avg('bytes');
		$this->bytes_min = $this->partialFlowstatsEthDst->min('bytes');
		$this->bytes_max = $this->partialFlowstatsEthDst->max('bytes');
		// $this->packets_std = DB::table('portstats')->select(DB::raw('STDDEV(tx_pkts)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		// $this->packets_avg = $this->partialPortstats->avg('rx_error');
		// $this->packets_min = $this->partialPortstats->min('rx_error');
		// $this->packets_max = $this->partialPortstats->max('rx_error');

		// $this->rx_error_avg = DB::table('portstats')->select(DB::raw('STDDEV(tx_pkts)'))->where('datapath', $this->selectedPortDP)->where('port',$s_port)->get();
		// $this->rx_error_avg = $this->partialPortstats->avg('rx_error');
		// $this->rx_error_min = $this->partialPortstats->min('rx_error');
		// $this->rx_error_max = $this->partialPortstats->max('rx_error');
	}
	/*
	public function render()
	{
		return view('livewire.flow-statistical-functions');
	}
	*/
	public function render()
	{
		$flowstats = FlowStat::all();
		$uniqueDP = $flowstats->unique('datapath');
		$data = array('flowstats' => $flowstats,
		'uniqueDP' => $uniqueDP);
		return view('livewire.flow-statistical-functions')
			->with($data);
	}
}
