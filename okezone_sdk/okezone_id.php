<?php

/* author  		  : Adi Sukma Wibawa
   email   		  : wibi.cms@gmail.com
   date_created   : 25/02/2015
   revised        : 
*/
 include('SessLib.php');
 include('Curl.php');

 class Okezone_Id{

 	private $api_url   		= 'https://id.okezone.com/api';
 	private $okezone_id_url = 'https://id.okezone.com';
 	private $url_callback 	= 'http://127.0.0.1/sso-php/demo.php/';
	private $client_id	  	= "";
	private $sess_lib;
	private $curl;

	public function __construct(){
		$this->sess_lib = new SessLib();
		$this->curl = new Curl();

		$this->set_okezone_id();
	}

	/*
	 * Generate login url
	 */
	public function get_login_url(){
		return $this->okezone_id_url.'/login/login_popup'
				.'?client_id='.$this->client_id
				.'&callback='.$this->url_callback
				.'&token_id='.$this->get_token();
	}

	/* 
	 * Generate logout url 
	 */
	public function get_logout_url(){
		return  $this->okezone_id_url.'/logout'
					.'?client_id='.$this->client_id
					.'&callback='.$this->url_callback
					.'&token_id='.$this->get_token();
	}


	/*
	 * Get token from current session 
	 */
	public function get_token(){
		$session_id = $this->sess_lib->get_session_id();
		return $session_id;
	}	


	/*
	 * Get User Data
	 */
	public function get_user_detail(){
			$okezone_id = $this->sess_lib->get('sso_okezone_id');
			
			$this->curl->get($this->api_url.'/user_detail', array(
				'token_id' => $this->get_token(),
				'okezone_id' => $okezone_id
			));
		
			return substr($this->curl->response, 1).'}';
		
	}

	/* 
	 * Post Activity 
	 */

	public function post_activity($params){
		$activity = array( 'token_id' => $this->get_token(),
						   'request_url' => $params['request_url'],
						   'okezone_id'  => $this->sess_lib->get('sso_okezone_id'),
						   'ip_address'	 => $this->get_ipaddress(),
						   'browser'	 => $this->get_user_agent(),
						   'log_type'	 => $params['log_type'],
						   'refferer'	 => $params['refferer'],
						   'author'		 => $params['author'],
						   'editor'		 => $params['editor'],
						   'published'	 => $params['published']);
		$this->curl->post($this->api_url.'/activity', $activity);
		
		return substr($this->curl->response, 1).'}';
	}
	

	private function set_okezone_id(){
		$okezone_id = $this->sess_lib->get('sso_okezone_id');
		if(empty($okezone_id)){
			$this->curl->get($this->api_url.'/okezone_id', array(
				'token_id'	=> $this->get_token()
				));

			if (!$this->curl->error) {

		    	$token_data = substr($this->curl->response, 1).'}';
		    	$token_data = json_decode($token_data);
		    	if($token_data->statusCode==200){
		    		$this->sess_lib->set(array('sso_okezone_id' => $token_data->data));
		    	}
			}
		}
	}
	

	private function get_ipaddress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	private function get_user_agent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}

	private function get_provider(){
		return $this->apps_name;
	}
 }
?>
