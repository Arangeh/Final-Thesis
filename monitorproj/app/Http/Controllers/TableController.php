<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlowStat;
use Illuminate\Support\Facades\DB;
use App\Models\PortStat;

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
}
