# Copyright (C) 2016 Nippon Telegraph and Telephone Corporation.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#    http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
# implied.
# See the License for the specific language governing permissions and
# limitations under the License.

from ryu.base import app_manager
from ryu.controller import ofp_event
from ryu.controller.handler import CONFIG_DISPATCHER, MAIN_DISPATCHER
from ryu.controller.handler import set_ev_cls
from ryu.ofproto import ofproto_v1_3
from ryu.lib.packet import packet
from ryu.lib.packet import ethernet

from operator import attrgetter

from ryu.app import simple_switch_13
from ryu.controller import ofp_event
from ryu.controller.handler import MAIN_DISPATCHER, DEAD_DISPATCHER
from ryu.controller.handler import set_ev_cls
from ryu.lib import hub
import json
import logging
import requests
from logging import Logger

#'''
class SimpleMonitor13(simple_switch_13.SimpleSwitch13):
	url_port = 'http://monitorproj.test/portstats/'
	url_flow = 'http://monitorproj.test/flowstats/'
	def __init__(self, *args, **kwargs):
		super(SimpleMonitor13, self).__init__(*args, **kwargs)
		
		self.datapaths = {}
		logging.basicConfig(filename='/home/alireza-a/monitor.log',encoding='utf-8')
		fh = logging.FileHandler('/home/alireza-a/monitor.log')
		fh.setLevel(logging.DEBUG)
		self.logger.addHandler(fh)
		
		self.monitor_thread = hub.spawn(self._monitor)

	@set_ev_cls(ofp_event.EventOFPStateChange,
				[MAIN_DISPATCHER, DEAD_DISPATCHER])
	def _state_change_handler(self, ev):
		datapath = ev.datapath
		if ev.state == MAIN_DISPATCHER:
			if datapath.id not in self.datapaths:
				# self.logger.debug('register datapath: %016x', datapath.id)
				self.datapaths[datapath.id] = datapath
		elif ev.state == DEAD_DISPATCHER:
			if datapath.id in self.datapaths:
				# self.logger.debug('unregister datapath: %016x', datapath.id)
				del self.datapaths[datapath.id]

	def _monitor(self):
		while True:
			for dp in self.datapaths.values():
				self._request_stats(dp)
			hub.sleep(10)

	def _request_stats(self, datapath):
		# self.logger.debug('send stats request: %016x', datapath.id)
		ofproto = datapath.ofproto
		parser = datapath.ofproto_parser

		req = parser.OFPFlowStatsRequest(datapath)
		datapath.send_msg(req)

		req = parser.OFPPortStatsRequest(datapath, 0, ofproto.OFPP_ANY)
		datapath.send_msg(req)

	@set_ev_cls(ofp_event.EventOFPFlowStatsReply, MAIN_DISPATCHER)
	def _flow_stats_reply_handler(self, ev):
		body = ev.msg.body
		for stat in sorted([flow for flow in body if flow.priority == 1],
						   key=lambda flow: (flow.match['in_port'],
											 flow.match['eth_dst'])):
			# Flow Stats in JSON
			monitor_dict = {
				"datapath": str(ev.msg.datapath.id),
				"in_port": str(stat.match['in_port']),  
				"eth_dst": stat.match['eth_dst'],
				"out_port": str(stat.instructions[0].actions[0].port),
				"packets": str(stat.packet_count),
				"bytes": str(stat.byte_count)
			}
			x = requests.post(self.url_flow, data=monitor_dict)
			self.logger.info(x.text)
			self.logger.info('%s', monitor_dict)
			self.logger.info('%s',json.dumps(monitor_dict))
	
											
	@set_ev_cls(ofp_event.EventOFPPortStatsReply, MAIN_DISPATCHER)
	def _port_stats_reply_handler(self, ev):
		body = ev.msg.body
		for stat in sorted(body, key=attrgetter('port_no')):
			# Port Stats in JSON
			monitor_dict={"datapath" : ev.msg.datapath.id,
			"port" : str(stat.port_no),
			"rx_pkts": str(stat.rx_packets),
			"rx_bytes": str(stat.rx_bytes),
			"rx_error": str(stat.rx_errors),			
			"tx_pkts": str(stat.tx_packets), 
			"tx_bytes": str(stat.tx_bytes),
			"tx_error": str(stat.tx_errors)
			}
			x = requests.post(self.url_port, data=monitor_dict)
			self.logger.info(x.text)
			self.logger.info('%s', monitor_dict)				 