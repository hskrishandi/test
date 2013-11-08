<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library("curl");
	}

	public function loadnodes() {
		$query = $this->db->query("SELECT * FROM computer_nodes");
		return $query->result();
	}

	public function selectnode($nodename) {
		$query = $this->db->query("SELECT * FROM computer_nodes WHERE nodename=?", array($nodename));
		if($query->num_rows() == 0)
			return false;
		else {
			$result = $query->result();
			return $result[0];
		}
	}

	public function checkapache() {
		echo trim(file_get_contents("/opt/httpd/logs/httpd.pid"));
	}

	public function checkps() {
		exec("ps axu | egrep 'mysqld|httpd|ngspice' | grep -v 'grep'", $r);
		echo json_encode($r);
	}

	public function cleartemp() {
		exec("rm /local/html/tmp/* -R");
		return true;
	}

	public function terminatengspice($pid) {
		exec("ps axu | egrep 'ngspice' | grep -v 'grep'", $lines);
		foreach($lines as $line)
			if(preg_match("/" . $pid . "/", $line)) {
				exec("kill -9 " . $pid);
				break;
			}
		return true;
	}

	public function remotelogin($node, $sites) {
		$username = "model@i-mos.org";
		$password = "imosdcl3113";

		$result = array();
		if(!($cookies = $this->session->userdata('curl_session'))) {
			$this->curl->create("http://" . $node->hostname . $node->path . "/account/login");
			$this->curl->post(array('email' => $username, 'pwd' => $password));
			$raw = $this->curl->execute();
			preg_match('/^Set-Cookie:\s*([^;]*)/mi', $raw, $m);
			parse_str($m[1], $cookies);
			
		}

		foreach($sites as $site) {
			$this->curl->create($site);
			$this->curl->get();
			$this->curl->set_cookies($cookies);
			$raw = $this->curl->execute();

			preg_match('/^Set-Cookie:\s*([^;]*)/mi', $raw, $m);
			preg_match('/Content-Length: ([0-9]+)/', $raw, $m1);
			if(preg_match('/Unauthorized Access/', $raw, $m2)) {
				$this->session->unset_userdata('curl_session');
				return false;
			}
			parse_str($m[1], $cookies);
			$result[] = substr($raw, -$m1[1]);
		}

		$this->session->set_userdata('curl_session', $cookies);

		return $result;
	}

}