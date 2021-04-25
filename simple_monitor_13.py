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
from ryu.ofproto import ofproto_v1_3_parser
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
#import datetime
from datetime import datetime
import random

#'''
class SimpleMonitor13(simple_switch_13.SimpleSwitch13):
	url_port = 'http://monitorproj.test/portstats/'
	url_flow = 'http://monitorproj.test/flowstats/'
	url_events = 'http://monitorproj.test/events/'
	url_switches = 'http://localhost:8080/stats/switches'
	url_switch_description_base = 'http://localhost:8080/stats/desc/'
	url_switch_description_laravel = 'http://monitorproj.test/swdesc'
	url_switch_ports_base = 'http://localhost:8080/stats/portdesc/'
	url_switch_ports_laravel = 'http://monitorproj.test/swportsdesc'
	url_switch_tables_base = 'http://localhost:8080/stats/table/'
	url_switch_tables_laravel = 'http://monitorproj.test/swtables'




	mfr = ''
	def __init__(self, *args, **kwargs):
		super(SimpleMonitor13, self).__init__(*args, **kwargs)
		
		self.datapaths = {}
		'''
		logging.basicConfig(filename='/home/alireza-a/monitor.log',encoding='utf-8')
		fh = logging.FileHandler('/home/alireza-a/monitor.log')
		fh.setLevel(logging.DEBUG)
		self.logger.addHandler(fh)
		'''
		#self.monitor_thread = hub.spawn(self._monitor)
		self.capabilities_configs_thread = hub.spawn(self._capabilities_configs)
		#self.capabilities_thread = hub.spawn(self._capabilities)
		#self.portdesc_thread = hub.spawn(self._portdesc)

	def _monitor(self):
		while True:
			for dp in self.datapaths.values():
				self._request_stats(dp)
				
			hub.sleep(10)

	def _capabilities_configs(self):
		while True:
			for dp in self.datapaths.values():
				self._request_caps_confs(dp)
				#self.logger.info('CAPABILITIES FOR THIS SWITCH')
			hub.sleep(5)	

	@set_ev_cls(ofp_event.EventOFPPortStatus, MAIN_DISPATCHER)
	def _port_status_handler(self, ev):
		msg = ev.msg
		dp = msg.datapath
		ofp = dp.ofproto

		
		msgjson = msg.to_jsondict()

		ofpportstat = msgjson['OFPPortStatus']
		description = ofpportstat['desc']
		#reason = ofpportstat['reason']
		ofpport = description['OFPPort']
	
		configstat = '<' + self._resolve_configuration(ofpport['config']) + '>'
		reason = self._resolve_reason(msg.reason)	
		state = self._resolve_state(ofpport['state'])	
		
		#curr_speed = ofpport['curr_speed']

		port_event_dict = {
			"type": 'port',
			"hw_addr": str(ofpport['hw_addr']),
			"name": str(ofpport['name']),  
			"datapath": str(dp.id),
			"state": state,
			"configstat": str(configstat),
			"curr_speed": ofpport['curr_speed'],
			"reason": reason,
			"timestamp": datetime.now()
		}

		self.logger.info('port_event_dic')
		self.logger.info(port_event_dict)
		#x = requests.post(self.url_events, data=port_event_dict)
		#self.logger.info("POST REQUEST FOR PORT")
		#self.logger.info(port_event_dict)
		#self.logger.info(x.text)
		#self.logger.info('%s', monitor_dict)
		#self.logger.info('%s',json.dumps(monitor_dict))

	@set_ev_cls(ofp_event.EventOFPStateChange,
				[MAIN_DISPATCHER, DEAD_DISPATCHER])
	def _state_change_handler(self, ev):
		datapath = ev.datapath
		if ev.state == MAIN_DISPATCHER:
			if datapath.id not in self.datapaths:
				#self.logger.info(datetime.datetime.now())	
				#self.logger.debug('register datapath: %016x', datapath.id)
				dp_event_dict = {
					"type" : 'datapath',  
					"datapath": str(datapath.id),
					"reason": 'Registered',
					"timestamp": datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
				}
				self.datapaths[datapath.id] = datapath
		elif ev.state == DEAD_DISPATCHER:
			if datapath.id in self.datapaths:
				#self.logger.info(datetime.datetime.now())
				#self.logger.debug('unregister datapath: %016x', datapath.id)
				dp_event_dict = {
					"type" : 'datapath',  
					"datapath": str(datapath.id),
					"reason": 'Unregistered',
					"timestamp": datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
				}
				del self.datapaths[datapath.id]
		#x = requests.post(self.url_events, data=dp_event_dict)
		#self.logger.info("POST REQUEST FOR PORT")
		#self.logger.info(dp_event_dict)
		#self.logger.info(x.text)	

	

	def _request_caps_confs(self, datapath):
		parser = datapath.ofproto_parser
		#x = requests.get(self.url_switches)

		dpid_str = str(datapath.id)
		s = self.url_switch_description_base + dpid_str
		#self.logger.info(s)
		x = requests.get(s)
		self.logger.info('yak yaketun')
		sw_description_dict = json.loads(x.text)
		
		sw_description_dict = sw_description_dict[dpid_str]
		sw_description_dict['datapath'] = dpid_str
		sw_description_dict['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
		
		x = requests.post(self.url_switch_description_laravel, data=sw_description_dict)
		self.logger.info(x.text)

		#s = self.url_switch_ports_base
		

	def _request_desc_stats(self, datapath):
		parser = datapath.ofproto_parser
		req = parser.OFPDescStatsRequest(datapath, 0)
		datapath.send_msg(req)
		
	def _request_stats(self, datapath):
		# self.logger.debug('send stats request: %016x', datapath.id)
		ofproto = datapath.ofproto
		parser = datapath.ofproto_parser		
		req = parser.OFPFlowStatsRequest(datapath)
		datapath.send_msg(req)

		req = parser.OFPPortStatsRequest(datapath, 0, ofproto.OFPP_ANY)
		datapath.send_msg(req)
		
	'''
	@set_ev_cls(ofp_event.EventOFPSwitchFeatures, MAIN_DISPATCHER)
	def switch_caps_handler(self, ev):
		self.logger.info('SIUUUU')
		# msg = ev.msg
		# self.logger.info(ev.port)
		# self.logger.debug('OFPSwitchFeatures received: '
		# 								'datapath_id=0x%016x n_buffers=%d '
		# 								'n_tables=%d capabilities=0x%08x ports=%s',
		# 								msg.datapath_id, msg.n_buffers, msg.n_tables,
		# 								msg.capabilities, msg.ports)
	
	@set_ev_cls(ofp_event.EventOFPDescStatsReply, MAIN_DISPATCHER)
	def desc_stats_reply_handler(self, ev):
		body = ev.msg.body
		self.logger.debug('DescStats: mfr_desc=%s hw_desc=%s sw_desc=%s '
											'serial_num=%s dp_desc=%s',
											body.mfr_desc, body.hw_desc, body.sw_desc,
											body.serial_num, body.dp_desc)
		self.mfr = body.mfr_desc										
	'''

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
			# self.logger.info("REQUEST")
			# self.logger.info(monitor_dict)
			# self.logger.info(x.text)
			self.logger.info('%s', monitor_dict)
			self.logger.info('%s',json.dumps(monitor_dict))
	
											
	@set_ev_cls(ofp_event.EventOFPPortStatsReply, MAIN_DISPATCHER)
	def _port_stats_reply_handler(self, ev):
		body = ev.msg.body
		for stat in sorted(body, key=attrgetter('port_no')):
			# Port Stats in JSON
			monitor_dict={"datapath" : str(ev.msg.datapath.id),
			"port" : str(stat.port_no),
			"rx_pkts": str(stat.rx_packets),
			"rx_bytes": str(stat.rx_bytes),
			"rx_error": str(stat.rx_errors),			
			"tx_pkts": str(stat.tx_packets), 
			"tx_bytes": str(stat.tx_bytes),
			"tx_error": str(stat.tx_errors),
			"rx_error": str(stat.rx_errors) + '\n YO'
			}
			x = requests.post(self.url_port, data=monitor_dict)
			# self.logger.info(x.text)
			self.logger.info("REQUEST")
			self.logger.info('%s', monitor_dict)		
	def _resolve_configuration(self, s):
		res = ''
		if s & ofproto_v1_3.OFPPC_PORT_DOWN != 0:
			res = res + ' Port is administratively down '
		elif s & ofproto_v1_3.OFPPC_NO_RECV != 0:
			res = res + ' Drop all packets recieved by port '
		elif s & ofproto_v1_3.OFPPC_NO_FWD != 0:
			res = res + ' Drop packets forwarded to port '
		elif s & ofproto_v1_3.OFPPC_NO_PACKET_IN != 0:		
			res = res + ' Do not send packet-in msgs for port '
		else:
			res = ' Port is up and running, with no constraint '
		return res

	def _resolve_reason(self, s):	
		if s == ofproto_v1_3.OFPPR_ADD:
			#reason = 'ADD'
			res = 'Added'
		elif s == ofproto_v1_3.OFPPR_DELETE:
			#reason = 'DELETE'
			res = 'Deleted'
		elif s == ofproto_v1_3.OFPPR_MODIFY:
			#reason = 'MODIFY'
			res = 'Modified some attribute(s) of'
		else:
			res = 'Unknown reason for'
		return res
	
	def _resolve_state(self, s):
		res = ''
		if s == ofproto_v1_3.OFPPS_LINK_DOWN:
			res = 'No physical link is present'
		elif s == ofproto_v1_3.OFPPS_BLOCKED:
			res = 'Port is blocked'
		elif s == ofproto_v1_3.OFPPS_LIVE:
			res = 'Live for Fast Failover Group'
		else:
			res = 'Unknown'
		return res				 