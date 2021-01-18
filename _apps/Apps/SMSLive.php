<?php

namespace Apps;

use stdClass;

class SMSLive
{

	public $smslive_owner_email = smslive_owner_email;
	public $smslive_subaccount = smslive_subaccount;
	public $smslive_subaccount_password = smslive_subaccount_password;

	public $api = "http://www.smslive247.com/http/index.aspx";

	public $SessionID = NULL;
	public $cmd = NULL;
	public $MsgType = 0;

	public $Sender = NULL;
	public $SendTo = array();
	public $Message = NULL;
	public $SendTime = NULL;

	public $variables = array();

	public function __construct()
	{
		$result = $this->Login();
		$this->SessionID = $result->session;
	}

	/**
	 * @param mixed $key 
	 * @param mixed $val 
	 * @return void 
	 */
	public function __set($key, $val)
	{
		$this->variables[$key] = $val;
	}

	/**
	 * @param mixed $key 
	 * @param mixed $val 
	 * @return void 
	 */
	public function __get($key)
	{
		return  $this->variables[$key];
	}


	public function debug($data="Stop:Debug!")
	{
		die($data); 
	}





	public function Login()
	{
		$result = new stdClass;
		$url = $this->api . "?cmd=login&owneremail={$this->smslive_owner_email}&subacct={$this->smslive_subaccount}&subacctpwd={$this->smslive_subaccount_password}";	
		$results = file_get_contents($url);
		$results = explode(':',$results);
		$result->status = trim($results[0]);
		$result->session = trim($results[1]);
		return $result; 
	}



	public function send($mobile,$message="")
	{
		$mobile = urlencode($mobile);
		$message = urlencode($message);
		$result = new stdClass;
		$url = $this->api . "?cmd=sendquickmsg&owneremail={$this->smslive_owner_email}&subacct={$this->smslive_subaccount}&subacctpwd={$this->smslive_subaccount_password}&message={$message}&sender=Golojan&sendto={$mobile}&msgtype=0";	
		$results = file_get_contents($url);
		$results = explode(':',$results);
		$result->status = trim($results[0]);
		$result->messageid = trim($results[1]);
		return $result; 
	}



	public function balance()
	{
		$result = new stdClass;
		$url = $this->api . "?cmd=querybalance&sessionid={$this->SessionID}";	
		$results = file_get_contents($url);
		$results = explode(':',$results);
		$result->status = trim($results[0]);
		$result->balance = trim($results[1]);
		return $result; 
	}



	
}
