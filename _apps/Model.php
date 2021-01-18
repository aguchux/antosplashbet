<?php

namespace Apps;

class Model
{

	public $debug = debug;
	public $default_timezone = default_timezone;
	public $offset_timezone = offset_timezone;

	public $session_timout = session_timout;

	public $data = debug;
	public $post = NULL;
	public $get = NULL;
	public $put = NULL;
	public $delete = NULL;
	public $files = NULL;
	public $request = NULL;

	//Database Settings
	public $host = db_host;
	public $user = db_user;
	public $password = db_password;
	public $db = db;

	public $_table = NULL;
	public $_table_key = NULL;
	public $_table_key_val = NULL;
	public $_keyset = array();
	public $_valset = array();
	public $_query = '';
	public $_keystring = array();

	public $key_array = array();
	public $data_array = array();
	public $form_posted_array = array();
	public $returned_posted_array = array();

	//Site Class variables
	public $dbCon = NULL;
	public $dbSel = "";

	public function __construct()
	{

		if (!$this->dbCon = mysqli_connect($this->host, $this->user, $this->password)) {
			exit('Error: Could not make a database connection using ' . $this->user . '@' . $this->host);
		}
		if (!$this->dbSel = mysqli_select_db($this->dbCon, $this->db)) {
			if (!mysqli_query($this->dbCon, "CREATE DATABASE IF NOT EXISTS {$this->db}")) {
				exit('Error: Could not select/create database ' . $this->db);
			}
		}
		mysqli_query($this->dbCon, "SET NAMES 'utf8'") or die(mysqli_error($this->dbCon));
		mysqli_query($this->dbCon, "SET CHARACTER SET utf8") or die(mysqli_error($this->dbCon));
		mysqli_query($this->dbCon, "SET SQL_MODE = ''") or die(mysqli_error($this->dbCon));

		if ($this->offset_timezone) {
			$now = new \DateTime();
			$mins = $now->getOffset() / 60;
			$sgn = ($mins < 0 ? -1 : 1);
			$mins = abs($mins);
			$hrs = floor($mins / 60);
			$mins -= $hrs * 60;
			$offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
			mysqli_query($this->dbCon, "SET time_zone = '{$offset}'");
		}

		if (isset($_POST)) {
			$this->data = $this->post = $this->post($_POST);
		} elseif (isset($_GET)) {
			$this->data = $this->get = $this->post($_GET);
		} else {
			$this->data = $this->request = $this->post($_REQUEST);
		}
		if (isset($_FILES)) {
			$this->files = $this->post($_FILES);
		}

		$this->unregisterGlobals();
	}

	public function debug($data = "Debug::Stoped")
	{
		if (is_array($data)) {
			print_r($data);
		} else {
			print_r($data);
		}
		exit();
	}

	/** Check if environment is development and display errors **/
	public function setReporting()
	{
		if ($this->debug == true) {
			error_reporting(E_ALL);
			ini_set('display_errors', "On");
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', "Off");
			ini_set('log_errors', "On");
			ini_set('error_log', __DIR__ . DS . '_tmp' . DS . 'logs' . DS . 'error.log');
		}
	}
	/** Check for Magic Quotes and remove them **/
	public function removeMagicQuotes()
	{
		$_GET = $this->stripSlashesDeep($_GET);
		$_POST = $this->stripSlashesDeep($_POST);
		$_COOKIE = $this->stripSlashesDeep($_COOKIE);
	}
	/** Check register globals and remove them **/
	public function unregisterGlobals()
	{
		if (ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}
	public function stripSlashesDeep($value)
	{
		$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
		return $value;
	}

	public function post($posted_array)
	{
		$this->form_posted_array = $posted_array;
		$forms = new \stdClass;
		if (is_array($posted_array)) {
			foreach ($posted_array as $key => $val) {
				if (is_array($val)) {
					$this->returned_posted_array[$key] = $val;
					$forms->$key = $val;
				} else {
					$this->returned_posted_array[$key] = $this->mysql_prepare_value($val);
					$forms->$key = $this->mysql_prepare_value($val);
				}
			}
			return $forms;
		} else {
			exit('Error: Form not good');
		}
	}

	public function mysql_prepare_value($value)
	{
		$new_version_php = function_exists("mysqli_real_escape_string");
		if ($new_version_php) {
			$value = stripslashes($value);
			$value = mysqli_real_escape_string($this->dbCon, $value);
		} else {
			$value = addslashes($value);
		}
		return $value;
	}


	public function countAffected()
	{
		return mysqli_affected_rows($this->dbCon);
	}

	public function getLastId()
	{
		return mysqli_insert_id($this->dbCon);
	}

	public function escape($value)
	{
		return mysqli_real_escape_string($this->dbCon, $value);
	}

	//MySQL Query functions
	public function query($sql)
	{

		$first_sql_command = explode(' ', $sql);
		$first_sql_command = strtoupper(trim($first_sql_command[0]));

		$resource = mysqli_query($this->dbCon, $sql);
		if ($resource) {
			if ($resource instanceof \mysqli_result) {
				$i = 0;
				$data = array();
				while ($result = mysqli_fetch_object($resource)) {
					$data[$i] = $result;
					$i++;
				}
				mysqli_free_result($resource);
				$query = new \stdClass();
				$query->row = isset($data[0]) ? $data[0] : array();
				$query->rows = $data;
				$query->num_rows = $i;
				unset($data);
				if ($first_sql_command == "INSERT") {
					return $this->getLastId();
				} else {
					if ($i == 1) {
						return $query->row;
					} else {
						return $query->rows;
					}
				}
			} else {
				return TRUE;
			}
		} else {
			exit('Error: ' . mysqli_error($this->dbCon) . '<br />Error No: ' . mysqli_errno($this->dbCon) . '<br />' . $sql);
		}
	}


	//MySQL Query functions
	public function execute($sql)
	{
		$resource = mysqli_query($this->dbCon, $sql);
		if ($resource) {
			if ($resource instanceof \mysqli_result) {
				return $resource;
			} else {
				return TRUE;
			}
		} else {
			exit('Error: ' . mysqli_error($this->dbCon) . '<br />Error No: ' . mysqli_errno($this->dbCon) . '<br />' . $sql);
		}
	}

	public function select($table, $params = null)
	{
		$this->_table = $table;
		if ($params != null) {
			$params = implode(",", $params);
			$this->_query .= " SELECT {$params} FROM {$table} ";
		} else {
			$this->_query .= " SELECT * FROM {$table} ";
		}
		return $this;
	}

	public function where($keyname)
	{
		$this->_query .= " WHERE {$keyname} ";
		return $this;
	}

	public function equals($keyval)
	{
		$this->_query .= " = '{$keyval}' ";
		return $this;
	}

	public function not_equals($keyval)
	{
		$this->_query .= " !='{$keyval}' ";
		return $this;
	}

	public function is($keyval)
	{
		$this->_query .= " = '{$keyval}' ";
		return $this;
	}

	public function is_not($keyval)
	{
		$this->_query .= " <>'{$keyval}' ";
		return $this;
	}

	public function not($keyval)
	{
		$this->_query .= " !='{$keyval}' ";
		return $this;
	}




	public function mysqli($query)
	{
		$resource = mysqli_query($this->dbCon, $query);
		if ($resource instanceof \mysqli_result) {
			return $resource;
		}
		return false;
	}

	public function run()
	{
		return $this->query($this->_query);
	}












	public function __destruct()
	{
		if (is_object($this->dbCon)) {
			mysqli_close($this->dbCon);
		}
	}
}
