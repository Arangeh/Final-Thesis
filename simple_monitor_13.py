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
from ryu.topology import event, switches
from ryu.topology.api import get_switch, get_link

#'''
class SimpleMonitor13(simple_switch_13.SimpleSwitch13):
	url_port = 'http://monitorproj.test/portstats/'
	url_flow = 'http://monitorproj.test/flowstats/'
	url_events = 'http://monitorproj.test/events/'
	url_switches = 'http://localhost:8080/stats/switches'
	url_switches_laravel = 'http://monitorproj.test/swids'
	url_switch_description_base = 'http://localhost:8080/stats/desc/'
	url_switch_description_laravel = 'http://monitorproj.test/swdesc'
	url_switch_ports_base = 'http://localhost:8080/stats/portdesc/'
	url_switch_ports_laravel = 'http://monitorproj.test/swportsdesc'
	url_switch_tables_base = 'http://localhost:8080/stats/table/'
	url_switch_tables_laravel = 'http://monitorproj.test/swtables'
	url_switch_flows_base = 'http://localhost:8080/stats/flow/'
	url_switch_flows_laravel = 'http://monitorproj.test/swflows'
	url_switch_features_laravel = 'http://monitorproj.test/swfeatures'
	url_switch_neighbors_laravel = 'http://monitorproj.test/neighbors'

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
		self.monitor_thread = hub.spawn(self._monitor)
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
		port_event_dict = {
			"type": 'port',
			"hw_addr": str(ofpport['hw_addr']),
			"name": str(ofpport['name']),  
			"datapath": str(dp.id),
			"state": state,
			"configstat": str(configstat),
			"curr_speed": ofpport['curr_speed'],
			"reason": reason,
			"timestamp": datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
		}
		x = requests.post(self.url_events, data=port_event_dict)
		#self.logger.info(x.text)

	@set_ev_cls(ofp_event.EventOFPStateChange,
				[MAIN_DISPATCHER, DEAD_DISPATCHER])
	def _state_change_handler(self, ev):
		datapath = ev.datapath
		if ev.state == MAIN_DISPATCHER:
			if datapath.id not in self.datapaths:
				dp_event_dict = {
					"type" : 'datapath',  
					"datapath": str(datapath.id),
					"reason": 'Registered',
					"timestamp": datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
				}
				self.datapaths[datapath.id] = datapath
		elif ev.state == DEAD_DISPATCHER:
			if datapath.id in self.datapaths:
				dp_event_dict = {
					"type" : 'datapath',  
					"datapath": str(datapath.id),
					"reason": 'Unregistered',
					"timestamp": datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
				}
				del self.datapaths[datapath.id]
		x = requests.post(self.url_events, data=dp_event_dict)
		self.logger.info(x.text)	

	

	def _request_caps_confs(self, datapath):
		parser = datapath.ofproto_parser
		dpid_str = str(datapath.id)
		#Getting switch description
		sw_id = {'datapath': dpid_str, 'timestamp': datetime.now().strftime("%d-%b-%Y, %H:%M:%S")}
		
		x = requests.post(self.url_switches_laravel, data=sw_id)
		s = self.url_switch_description_base + dpid_str
		
		x = requests.get(s)

		sw_description_dict = json.loads(x.text)
		sw_description_dict = sw_description_dict[dpid_str]
		sw_description_dict['datapath'] = dpid_str
		sw_description_dict['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
		
		x = requests.post(self.url_switch_description_laravel, data=sw_description_dict)
		#self.logger.info(x.text)
		
		#Getting port information about the switch
		s = self.url_switch_ports_base + dpid_str
		x = requests.get(s)
		sw_ports_dict = json.loads(x.text)

		for port in sw_ports_dict[dpid_str]:
			
			port['datapath'] = dpid_str
			port['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
			port['config'] = self._resolve_configuration(port['config'])
			port['state'] = self._resolve_state(port['state'])
			port = self._stringify_dict_values(port)
			x = requests.post(self.url_switch_ports_laravel, data=port)
			#self.logger.info(x.text)
		
		s = self.url_switch_tables_base + dpid_str
		x = requests.get(s)
		sw_tables_dict = json.loads(x.text)
		for table in list(filter(lambda x: (x['active_count'] != 0), sw_tables_dict[dpid_str])):
			table['datapath'] = dpid_str
			table['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
			table = self._stringify_dict_values(table)
			x = requests.post(self.url_switch_tables_laravel, data=table)
			self.logger.info(x.text)
		#Getting flow table of the switch
		s = self.url_switch_flows_base + dpid_str
		x = requests.get(s)
		flows = json.loads(x.text)[dpid_str]
		flow_dict = {}
		for i in range(len(flows)):
			flow_dict['datapath'] = dpid_str
			flow_dict['flow_id'] = i
			flow_dict['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
			try:
				flow_dict['in_port'] = flows[i]['match']['in_port']
			except:
				flow_dict['in_port'] = 'N/A'
				pass
			try:
				flow_dict['dl_dst'] = flows[i]['match']['dl_dst']
			except:
				flow_dict['dl_dst'] = 'N/A'
				pass	
			flow_dict['priority'] = flows[i]['priority']
			flow_dict['cookie'] = flows[i]['cookie']
			flow_dict['hard_timeout'] = flows[i]['hard_timeout']
			flow_dict['duration_sec'] = flows[i]['duration_sec']
			flow_dict['packet_count']	= flows[i]['packet_count']
			flow_dict['actions'] = flows[i]['actions'][0]
			flow_dict['table_id'] = flows[i]['table_id']
			flow_dict = self._stringify_dict_values(flow_dict)

			x = requests.post(self.url_switch_flows_laravel,data=flow_dict)
			self.logger.info(x.text)
		
	def _request_stats(self, datapath):
		ofproto = datapath.ofproto
		parser = datapath.ofproto_parser
		req = parser.OFPFlowStatsRequest(datapath)
		datapath.send_msg(req)

		req = parser.OFPPortStatsRequest(datapath, 0, ofproto.OFPP_ANY)
		datapath.send_msg(req)

	def _send_features_request(self, datapath):
		ofp_parser = datapath.ofproto_parser
		req = ofp_parser.OFPFeaturesRequest(datapath)
		datapath.send_msg(req)
	
	@set_ev_cls(ofp_event.EventOFPSwitchFeatures, MAIN_DISPATCHER)
	def switch_caps_handler(self, ev):
		msg = ev.msg
		switch_features_dict = msg.to_jsondict()['OFPSwitchFeatures']
		switch_features_dict['capabilities'] = self._resolve_capabilities(switch_features_dict['capabilities'])
		switch_features_dict['timestamp'] = datetime.now().strftime("%d-%b-%Y, %H:%M:%S")
		switch_features_dict = self._stringify_dict_values(switch_features_dict)
		x = requests.post(self.url_switch_features_laravel, data=switch_features_dict)
		#self.logger.info(x.text)

	@set_ev_cls(ofp_event.EventOFPFlowStatsReply, MAIN_DISPATCHER)
	def _flow_stats_reply_handler(self, ev):
		body = ev.msg.body
		for stat in sorted([flow for flow in body if flow.priority == 1],
							 key=lambda flow: (flow.match['in_port'],
											 flow.match['eth_dst'])):
			# Flow Stats in JSON
			monitor_flow_dict = {
				"datapath": ev.msg.datapath.id,
				"in_port": stat.match['in_port'],  
				"eth_dst": stat.match['eth_dst'],
				"out_port": stat.instructions[0].actions[0].port,
				"packets": stat.packet_count,
				"bytes": stat.byte_count
			}
			monitor_flow_dict = self._stringify_dict_values(monitor_flow_dict)
			x = requests.post(self.url_flow, data=monitor_flow_dict)
			# self.logger.info(x.text)
	
	@set_ev_cls(ofp_event.EventOFPPortStatsReply, MAIN_DISPATCHER)
	def _port_stats_reply_handler(self, ev):
		body = ev.msg.body
		for stat in sorted(body, key=attrgetter('port_no')):
			# Port Stats in JSON
			monitor_port_dict={"datapath" : ev.msg.datapath.id,
			"port" : stat.port_no,
			"rx_pkts": stat.rx_packets,
			"rx_bytes": stat.rx_bytes,
			"rx_error": stat.rx_errors,			
			"tx_pkts": stat.tx_packets, 
			"tx_bytes": stat.tx_bytes,
			"tx_error": stat.tx_errors,
			"rx_error": stat.rx_errors
			}
			monitor_port_dict = self._stringify_dict_values(monitor_port_dict)
			x = requests.post(self.url_port, data=monitor_port_dict)
			# self.logger.info(x.text)

	def _resolve_configuration(self, s):
		res = ''
		if s & ofproto_v1_3.OFPPC_PORT_DOWN != 0:
			res = res + ' Port is administratively down '
		if s & ofproto_v1_3.OFPPC_NO_RECV != 0:
			res = res + ' Drop all packets recieved by port '
		if s & ofproto_v1_3.OFPPC_NO_FWD != 0:
			res = res + ' Drop packets forwarded to port '
		if s & ofproto_v1_3.OFPPC_NO_PACKET_IN != 0:		
			res = res + ' Do not send packet-in msgs for port '
		if s & (ofproto_v1_3.OFPPC_PORT_DOWN | ofproto_v1_3.OFPPC_NO_RECV | s & ofproto_v1_3.OFPPC_NO_FWD | ofproto_v1_3.OFPPC_NO_PACKET_IN) == 0:
			res = ' Port is up and running, with no constraint '
		return res

	def _resolve_reason(self, s):	
		if s == ofproto_v1_3.OFPPR_ADD:
			res = 'Added'
		elif s == ofproto_v1_3.OFPPR_DELETE:
			res = 'Deleted'
		elif s == ofproto_v1_3.OFPPR_MODIFY:
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

	def _resolve_capabilities(self, s):
		res = ''
		if s & ofproto_v1_3.OFPC_FLOW_STATS != 0:
			res = res + ' Flow statistics '
		if s & ofproto_v1_3.OFPC_TABLE_STATS != 0:
			res = res + ' Table statistics '
		if s & ofproto_v1_3.OFPC_PORT_STATS != 0:
			res = res + ' Port statistics '
		if s & ofproto_v1_3.OFPC_GROUP_STATS != 0:
			res = res + ' Group statistics '
		if s & ofproto_v1_3.OFPC_IP_REASM != 0:
			res = res + ' Can reassemble IP fragments '
		if s & ofproto_v1_3.OFPC_QUEUE_STATS != 0:
			res = res + ' Queue statistics '
		if s & ofproto_v1_3.OFPC_PORT_BLOCKED != 0:
			res = res + ' Switch will block looping ports '
		if s & (ofproto_v1_3.OFPC_FLOW_STATS | ofproto_v1_3.OFPC_TABLE_STATS | ofproto_v1_3.OFPC_PORT_STATS | ofproto_v1_3.OFPC_GROUP_STATS | ofproto_v1_3.OFPC_IP_REASM | ofproto_v1_3.OFPC_QUEUE_STATS | ofproto_v1_3.OFPC_PORT_BLOCKED) == 0:
			res = ' unknown '
		return res
	'''	
	@set_ev_cls(event.EventSwitchEnter)
	def get_topology_data(self, ev):
		switch_list =et_ev_cls(event.EventSwitchEnter)
	def get_topology_data(self, ev):
		switch_list = get_switch(self.topology_api_app, None)
		switches=[switch.dp.id for switch in switch_list]
		links_list = get_link(self.topology_api_app, None)
		 get_switch(self.topology_api_app, None)
		switches=[switch.dp.id for switch in switch_list]
		links_list = get_link(self.topology_api_app, None)
		links=[(link.src.dpid,link.dst.dpid,{'port':link.src.port_no}) for link in links_list]
		request.post(self.url_switch_neighbors_laravel)
	'''
	def _stringify_dict_values(self, d):
		key_values = d.items()
		new_d = {str(key): str(value) for key, value in key_values}
		return new_d					 