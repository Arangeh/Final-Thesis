<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PortStat;
use App\Models\Event;
use App\Models\FlowStat;
use App\Models\SwitchDescription;


class TableController extends Controller
{

	public function deleteAllPortStats()
	{
		DB::table('portstats')->delete();
		return redirect('/portstats');
	}
	public function getAllPortStats(Request $req)
	{
		$portstats = DB::table('portstats')->paginate(12);
		return view('portstats', compact('portstats'));
	}
	public function addPort(Request $req)
	{
		$portstat = new PortStat;
		$portstat->datapath = $req->datapath;
		$portstat->port = $req->port;
		$portstat->rx_pkts = $req->rx_pkts;
		$portstat->rx_bytes = $req->rx_bytes;
		$portstat->tx_pkts = $req->tx_pkts;
		$portstat->tx_bytes = $req->tx_bytes;
		$portstat->tx_error = $req->tx_error;
		$portstat->rx_error = $req->rx_error;
		$result = $portstat->save();
		if ($result) {

			return ["Result" => "Data has been saved","tx_bytes" => $req];
		}
		return ["Result" => "Operation failed"];
	}
	public function addFlow(Request $req)
	{
		$flowstat = new FlowStat;
		$flowstat->datapath = $req->datapath;
		$flowstat->in_port = $req->in_port;
		$flowstat->eth_dst = $req->eth_dst;
		$flowstat->out_port = $req->out_port;
		$flowstat->packets = $req->packets;
		$flowstat->bytes = $req->bytes;
		$result = $flowstat->save();
		if ($result) {
			return ["Result" => "Data has been saved"];
		}
		return ["Result" => "Operation failed"];
	}
	public function deleteAllFlowStats()
	{
		DB::table('flowstats')->delete();
		return redirect('/flowstats');
	}
	public function getAllFlowStats(Request $req)
	{
		$flowstats = DB::table('flowstats')->paginate(12);
		return view('flowstats', compact('flowstats'));
	}

	public function addEvent(Request $req)
	{
		$event = new Event;
		$event->datapath = $req->datapath;
		$event->timestamp = $req->timestamp;
		$event->type = $req->type;
		$event->reason = $req -> reason;
		if($req->type === 'port')
		{
			//Some additional columns need to be filled
			$event->hw_addr = $req->hw_addr;  
			$event->name = $req->name;
			$event->state = $req->state;
			$event->configstat = $req->configstat;
			$event->curr_speed = $req->curr_speed;
			$event->reason = $req->reason;

		}
		else
		{
			//Its type is datapath and we don't need any extra columns to be filled
		}
		
		$result = $event->save();
		if ($result) {
			return ["Result" => "Data has been saved"];
		}
		return ["Result" => "Operation failed"];
	}
	public function deleteAllEvents()
	{
		DB::table('events')->delete();
		return redirect('/events');
	}
	public function getAllEvents(Request $req)
	{
		$events = DB::table('events')->paginate(12);
		return view('events', compact('events'));
	}
		
	public function addSwitchDescription(Request $req)
	{
		//$sw_desc_record = new SwitchDescription;
		$sw_desc_record = SwitchDescription::firstOrNew(['datapath' => ($req->datapath)]);
		$sw_desc_record->timestamp = $req->timestamp;
		$sw_desc_record->mfr_desc = $req->mfr_desc;
		$sw_desc_record->hw_desc = $req->hw_desc;
		$sw_desc_record->sw_desc = $req->sw_desc;
		$sw_desc_record->serial_num = $req->serial_num;
		$sw_desc_record->dp_desc = $req->dp_desc;
		$result = $sw_desc_record->save();
		if ($result) {
			return ["Result" => "Data has been saved"];
		}
		return ["Result" => "Operation failed"];
	}
}
