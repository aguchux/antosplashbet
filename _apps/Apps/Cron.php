<?php

namespace Apps;

class Cron
{

	public $_job = NULL;
	public $_tor = NULL;
	public $_exeurl = NULL;
	public $variables = array();
    

	public function __construct($url)
	{
        $this->_exeurl = $url;
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
    




	

    

	
}
