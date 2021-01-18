<?php

//Write your custome class/methods here
namespace Apps;

use \Apps\Model;
use \Apps\EmailTemplate;
use \Apps\Session;

use stdClass;


class Core extends Model
{

	public $token = NULL;
	public $ngn = "&#x20A6;";
	public $session_timout = session_timout;

	/** @return exit  */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param int $length 
	 * @return string 
	 */
	public function GenPassword($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * @param int $length 
	 * @return string 
	 */
	public function GenOTP($length = 10)
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return strtoupper($randomString);
	}


	public function GenTeamCode($loid, $length = 3)
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $loid . $randomString;
	}


	/**
	 * @param mixed $amount 
	 * @return string 
	 */
	public function ToMoney($amount)
	{
		$amount = number_format($amount, 2, ".", ",");
		return "&#x20A6;" . $amount;
	}

	/**
	 * @param mixed $amount 
	 * @return string 
	 */
	public function ToNGN($amount)
	{
		$amount = number_format($amount, 2, ".", ",");
		return "NGN " . $amount;
	}

	/** @return string  */
	public function NGN()
	{
		return "&#x20A6;";
	}





	/**
	 * Shorten large numbers into abbreviations (i.e. 1,500 = 1.5k)
	 *
	 * @param int    $number  Number to shorten
	 * @return String   A number with a symbol
	 */
	function shorten($number)
	{
		$abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

		foreach ($abbrevs as $exponent => $abbrev) {
			if ($number >= pow(10, $exponent)) {
				$display_num = $number / pow(10, $exponent);
				$decimals = ($exponent >= 3 && round($display_num) < 100) ? 2 : 1;
				return "&#x20A6; " . number_format($display_num, $decimals) . $abbrev;
			}
		}
	}


	/**
	 * @param mixed $amount 
	 * @return string 
	 */
	public function Monify($amount)
	{
		$amount = number_format($amount, 2, ".", ",");
		return "&#x20A6;" . $amount;
	}

	public function Numberfy($amount)
	{
		$amount = number_format($amount, 0, ".", ",");
		return $amount;
	}
	public function Comma2Dec($amount)
	{
		$amount = 0 + str_replace(",", "", $amount);
		$amount = number_format($amount, 2, ".", "");
		return $amount;
	}

	/**
	 * @param mixed $string 
	 * @return string 
	 */
	public static function slugify($string)
	{
		$table = array(
			'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
			'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
			'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
			'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
			'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
			'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-', ',' => '', '&' => 'and'
		);
		// -- Remove duplicated spaces
		$stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/', '/[^a-z0-9]/i'), ' ', $string);
		// -- Returns the slug
		return strtolower(strtr($string, $table));
	}

	/** @return string  */
	public function getURI()
	{
		$getURI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		return $getURI;
	}

	/**
	 * @param string $url 
	 * @return exit 
	 */
	public function redirect($url = "/")
	{
		header("Location: {$url}");
		exit();
	}

	/**
	 * @param mixed $password 
	 * @return string 
	 */
	public function Passwordify($password)
	{
		$Passwordify = md5($password);
		return $Passwordify;
	}
	/**
	 * @param mixed $data 
	 * @return string 
	 */
	public function encode($data)
	{
		$encode = sha1(md5($data));
		return $encode;
	}


	public function PlayTime($time_to_play, $format = 's')
	{

		$current_time    = time();
		$time_difference = $time_to_play - $current_time;
		$seconds         = $time_difference;

		$minutes = round($seconds / 60); // value 60 is seconds
		$hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks   = round($seconds / 604800); // 7*24*60*60;
		$months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

		switch ($format) {
			case 'minutes':
				return $minutes;
				break;
			case 'hours':
				return $hours;
				break;
			case 'days':
				return $days;
				break;
			case 'weeks':
				return $weeks;
				break;
			case 'months':
				return $months;
				break;
			case 'years':
				return $years;
				break;
			default:
				return $seconds;
				break;
		}
	}




	public function timelap($time_ago, $format = 's')
	{

		$current_time    = time();
		$time_difference = $current_time - $time_ago;
		$seconds         = $time_difference;

		$minutes = round($seconds / 60); // value 60 is seconds
		$hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks   = round($seconds / 604800); // 7*24*60*60;
		$months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

		switch ($format) {
			case 'minutes':
				return $minutes;
				break;
			case 'hours':
				return $hours;
				break;
			case 'days':
				return $days;
				break;
			case 'weeks':
				return $weeks;
				break;
			case 'months':
				return $months;
				break;
			case 'years':
				return $years;
				break;
			default:
				return $seconds;
				break;
		}
	}

	/**
	 * @param mixed $time_ago 
	 * @return string 
	 */
	public function Cycle($time_ago)
	{
		$current_time    = time();
		$time_difference = $current_time - $time_ago;
		$seconds         = $time_difference;

		$minutes = round($seconds / 60); // value 60 is seconds
		$hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks   = round($seconds / 604800); // 7*24*60*60;
		$months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
		$years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

		if ($seconds <= 60) {
			return "Just Now";
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "one minute ago";
			} else {
				return "$minutes minutes ago";
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour ago";
			} else {
				return "$hours hrs ago";
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days ago";
			}
		} else if ($weeks <= 4.3) {
			if ($weeks == 1) {
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		} else if ($months <= 12) {
			if ($months == 1) {
				return "a month ago";
			} else {
				return "$months months ago";
			}
		} else {
			if ($years == 1) {
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}

	/**
	 * @param mixed $mins 
	 * @return string 
	 */
	public function AddMinsToDate($mins)
	{
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Africa/Lagos'));
		$date->modify("+{$mins} minutes");
		return $date->format('Y-m-d h:i:s');
	}

	/**
	 * @param mixed $days 
	 * @return string 
	 */
	public function AddDaysToDate($days)
	{
		$mins = $days * 24 * 60;
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Africa/Lagos'));
		$date->modify("+{$mins} minutes");
		return $date->format('Y-m-d h:i:s');
	}

	/**
	 * @param mixed $mins 
	 * @return string 
	 */
	public function RemoveMinsFromDate($mins)
	{
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Africa/Lagos'));
		$date->modify("-{$mins} minutes");
		return $date->format('Y-m-d h:i:s');
	}

	/**
	 * @param mixed $days 
	 * @return string 
	 */
	public function RemoveDaysFromDate($days)
	{
		$mins = $days * 24 * 60;
		$date = new \DateTime();
		$date->setTimezone(new \DateTimeZone('Africa/Lagos'));
		$date->modify("-{$mins} minutes");
		return $date->format('Y-m-d h:i:s');
	}

	/**
	 * @param mixed $path 
	 * @return bool 
	 */
	public function createPath($path)
	{
		if (is_dir($path)) return true;
		$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1);
		$return = $this->createPath($prev_path);
		return ($return && is_writable($prev_path)) ? mkdir($path, 0777, true) : false;
	}

	/**
	 * @param mixed $FileDir 
	 * @param mixed $fileObj 
	 * @param int $height 
	 * @param int $width 
	 * @return string|false|void 
	 */

	/**
	 * @param mixed $start 
	 * @param mixed $end 
	 * @return \stdClass 
	 */
	public function dateDiff($start, $end)
	{

		$dateDiff = new \stdClass;

		// Declare and define two dates
		$date1 = strtotime($start);
		$date2 = strtotime($end);

		// Formulate the Difference between two dates
		$diff = abs($date2 - $date1);
		$dateDiff->diff = $diff;

		// To get the year divide the resultant date into
		// total seconds in a year (365*60*60*24)
		$years = floor($diff / (365 * 60 * 60 * 24));
		$dateDiff->years = $years;

		// To get the month, subtract it with years and
		// divide the resultant date into
		// total seconds in a month (30*60*60*24)
		$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$dateDiff->months = $months;

		// To get the day, subtract it with years and
		// months and divide the resultant date into
		// total seconds in a days (60*60*24)
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		$dateDiff->days = $days;

		// To get the hour, subtract it with years,
		// months & seconds and divide the resultant
		// date into total seconds in a hours (60*60)
		$hours = floor(($diff - $years * 365 * 60 * 60 * 24  - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
		$dateDiff->hours = $hours;

		// To get the minutes, subtract it with years,
		// months, seconds and hours and divide the
		// resultant date into total seconds i.e. 60
		$minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
		$dateDiff->minutes = $minutes;

		// To get the minutes, subtract it with years,
		// months, seconds, hours and minutes
		$seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));
		$dateDiff->seconds = $seconds;

		return $dateDiff;
	}

	/**
	 * @param mixed $filepath 
	 * @return int 
	 */
	public function CountExcelRows($filepath)
	{
		$file = new \SplFileObject($filepath, 'r');
		$file->seek(PHP_INT_MAX);
		$CountExcelRows = $file->key() + 1;
		return $CountExcelRows;
	}


	/**
	 * @param mixed $imgpath 
	 * @return string 
	 */
	public function SetDivBg($imgpath)
	{
		$htm = "";
		$htm .= "background-image: url('{$imgpath}');";
		$htm .= "background-position:center;";
		$htm .= "background-repeat:no-repeat;";
		$htm .= "background-size:cover;";
		return $htm;
	}



	// Email Sending Codes//

	/**
	 * @param mixed $email 
	 * @param mixed $fullname 
	 * @param mixed $subject 
	 * @param mixed $body 
	 * @param string $type 
	 * @return void 
	 */
	public function sendMail($email, $fullname, $subject, $body, $template = 'mails.default')
	{
		$Mailer = new Emailer();
		$EmailTemplate = new EmailTemplate($template);
		$EmailTemplate->subject = $subject;
		$EmailTemplate->fullname = $fullname;
		$EmailTemplate->mailbody = $body;
		$Mailer->SetTemplate($EmailTemplate);
		$Mailer->toEmail = $email;
		$Mailer->toName = "{$fullname}";
		$Mailer->subject = "{$subject}";
		$Mailer->fromEmail = "notix@supperodds.com";
		$Mailer->fromName = "Supper.Odds";
		$Mailer->send();
	}
	// Email Sending Codes//


	/**
	 * @param mixed $username 
	 * @return object|null 
	 */
	public function UserInfo($username)
	{
		$UserInfo = mysqli_query($this->dbCon, "select * from sup_accounts where email='$username' OR accid='$username' OR mobile='$username'");
		$UserInfo = mysqli_fetch_object($UserInfo);
		return $UserInfo;
	}

	public function CountUsers()
	{

		$result = new \stdClass;

		$CountUsers = mysqli_query($this->dbCon, "select count(accid) as nusers from sup_accounts");
		$CountUsers = mysqli_fetch_object($CountUsers);
		$result->nusers = $CountUsers->nusers;

		$now_time = time();

		$CountOnlineUsers = mysqli_query($this->dbCon, "SELECT count(*) As ousers FROM `sup_accounts` WHERE `lastaction` >= DATE_SUB(NOW(), INTERVAL {$this->session_timout} MINUTE)");
		$CountOnlineUsers = mysqli_fetch_object($CountOnlineUsers);
		$result->ousers = $CountOnlineUsers->ousers;

		return $result;
	}


	public function adminUsers()
	{
		$adminUsers = mysqli_query($this->dbCon, "select * from sup_accounts ORDER BY accid ASC");
		return $adminUsers;
	}


	public function AddAgent($fullname, $email, $mobile, $password, $createdby, $role, $isadmin)
	{

		mysqli_query($this->dbCon, "INSERT INTO sup_accounts(fullname,email,mobile,password,createdby,role,is_admin)
		 VALUES('$fullname','$email','$mobile','$password','$createdby','$role','$isadmin')");
		return (int)$this->getLastId();
	}

	public function AddNewOdd($home, $away, $odds, $win, $accid, $playdate, $playdate_hrs, $playdate_mins,$playdate_period,$windate,$windate_hrs, $windate_mins, $windate_period)
	{

		mysqli_query($this->dbCon, "INSERT INTO sup_odds(home,away,odds,win,accid,playdate,playdate_hrs,playdate_mins,playdate_period,windate,windate_hrs,windate_mins,windate_period)
		 VALUES('$home','$away','$odds','$win','$accid','$playdate','$playdate_hrs','$playdate_mins','$playdate_period','$windate','$windate_hrs','$windate_mins','$windate_period')");
		return (int)$this->getLastId();
	}


	public function SetOddsInfo($oddid, $key, $val)
	{
		mysqli_query($this->dbCon, "UPDATE sup_odds SET $key='$val' where id='$oddid'");
		return mysqli_affected_rows($this->dbCon);
	}




	/**
	 * @param mixed $username 
	 * @param mixed $password 
	 * @return object|null 
	 */
	public function UserLogin($username, $password)
	{
		$UserLogin = mysqli_query($this->dbCon, "select * from sup_accounts where (email='$username' OR mobile='$username') AND password='$password'");
		$UserLogin = mysqli_fetch_object($UserLogin);
		$this->SetUserInfo($UserLogin->accid, "lastseen", date("Y-m-d g:i:s"));

		return $UserLogin;
	}

	/**
	 * @param mixed $username 
	 * @param mixed $key 
	 * @param mixed $val 
	 * @return int 
	 */
	public function SetUserInfo($username, $key, $val)
	{
		mysqli_query($this->dbCon, "UPDATE sup_accounts SET $key='$val' where email='$username' OR accid='$username' OR mobile='$username'");
		return mysqli_affected_rows($this->dbCon);
	}

	public function UserExists($username)
	{
		$UserExists = mysqli_query($this->dbCon, "select * from sup_accounts where email='$username' OR accid='$username' OR mobile='$username'");
		$UserExists = mysqli_fetch_object($UserExists);
		if (isset($UserExists->accid)) {
			return $UserExists;
		}
		return false;
	}

	public function SearchClient($mobile)
	{
		$SearchClient = mysqli_query($this->dbCon, "select count(*) AS cnt from sup_clients where mobile='$mobile'");
		$SearchClient = mysqli_fetch_object($SearchClient);
		return $SearchClient->cnt;
	}


	public function DebitAgent($username, $amount)
	{

		mysqli_query($this->dbCon, "UPDATE sup_accounts SET `credit`=`credit`-'$amount' where email='$username' OR accid='$username' OR mobile='$username'");
		return mysqli_affected_rows($this->dbCon);
	}

	public function CreditAgent($agentid, $abc, $amount, $aac, $accid)
	{

		mysqli_query($this->dbCon, "INSERT INTO sup_credits(agentid,abc,amount,aac,accid) VALUES('$agentid','$abc','$amount','$aac','$accid')");
		return mysqli_affected_rows($this->dbCon);
	}



	public function VerifyOTP($accid, $otp)
	{

		$Sess = new Session;

		$VerifyOTP = mysqli_query($this->dbCon, "select * from ebsg_accounts where accid='$accid'");
		$VerifyOTP = mysqli_fetch_object($VerifyOTP);

		$otp_pending = (int)$VerifyOTP->otp_pending;
		$otp_time = strtotime($VerifyOTP->otp_time);
		$savedotp = $VerifyOTP->otp;
		if ($otp_pending) {
			//Check if it hasn't expiered//
			$now_time = strtotime(date("Y-m-d g:i:s"));
			$t_diff = $now_time - $otp_time;
			$t_mins = round($t_diff / 60);
			if ($t_mins <= otp_live_time) {
				$otp_match = (int)$otp == $savedotp;
				$Sess->removedata('accid');
				return $otp_match;
			} else {
				$Sess->removedata('accid');
				return (int)false;
			}
		}
		return (int)false;
	}






	public function MyTransactions($accid)
	{
		$MyTransactions = mysqli_query($this->dbCon, "select * from sup_transactions WHERE accid='$accid'");

		return $MyTransactions;
	}



	public function NewTransaction($accid, $clientid, $oddid, $amount, $paid = true)
	{
		$transid = sha1("{$accid}{$clientid}{$oddid},{$amount}" . time());
		$status = $paid ? "paid" : "unpaid";

		$CreateClient = mysqli_query($this->dbCon, "INSERT INTO sup_transactions(transid,accid,clientid,odd,amount,status) VALUES('$transid','$accid','$clientid','$oddid','$amount','$status')");
		return $this->getLastId();
	}

	public function SumAgentTransactions($accid)
	{
		$SumAgentTransactions = mysqli_query($this->dbCon, "SELECT SUM(amount) AS asum from sup_transactions WHERE accid='$accid' OR status='paid'");
		$SumAgentTransactions = mysqli_fetch_object($SumAgentTransactions);
		return floatval($SumAgentTransactions->asum);
	}

	public function SumAgentUnpaidTransactions($accid)
	{
		$SumAgentUnpaidTransactions = mysqli_query($this->dbCon, "SELECT SUM(amount) AS asum from sup_transactions WHERE accid='$accid' OR status='unpaid'");
		$SumAgentUnpaidTransactions = mysqli_fetch_object($SumAgentUnpaidTransactions);
		return floatval($SumAgentUnpaidTransactions->asum);
	}
	public function CountAgentTransactions($accid)
	{
		$CountAgentTransactions = mysqli_query($this->dbCon, "SELECT COUNT(id) AS acnt from sup_transactions WHERE accid='$accid' OR status='paid'");
		$CountAgentTransactions = mysqli_fetch_object($CountAgentTransactions);
		return intval($CountAgentTransactions->acnt);
	}

	public function CountAgentClients($accid)
	{
		$CountAgentClients = mysqli_query($this->dbCon, "SELECT COUNT(id) AS acnt from sup_clients WHERE accid='$accid'");
		$CountAgentClients = mysqli_fetch_object($CountAgentClients);
		return intval($CountAgentClients->acnt);
	}




	public function SumAdminTransactions()
	{
		$SumAgentTransactions = mysqli_query($this->dbCon, "SELECT SUM(amount) AS asum from sup_transactions WHERE status='paid'");
		$SumAgentTransactions = mysqli_fetch_object($SumAgentTransactions);
		return floatval($SumAgentTransactions->asum);
	}

	public function SumAdminUnpaidTransactions()
	{
		$SumAgentUnpaidTransactions = mysqli_query($this->dbCon, "SELECT SUM(amount) AS asum from sup_transactions WHERE status='unpaid'");
		$SumAgentUnpaidTransactions = mysqli_fetch_object($SumAgentUnpaidTransactions);
		return floatval($SumAgentUnpaidTransactions->asum);
	}
	public function CountAdminTransactions()
	{
		$CountAgentTransactions = mysqli_query($this->dbCon, "SELECT COUNT(id) AS acnt from sup_transactions WHERE status='paid'");
		$CountAgentTransactions = mysqli_fetch_object($CountAgentTransactions);
		return intval($CountAgentTransactions->acnt);
	}

	public function CountAdminClients()
	{
		$CountAgentClients = mysqli_query($this->dbCon, "SELECT COUNT(id) AS acnt from sup_clients");
		$CountAgentClients = mysqli_fetch_object($CountAgentClients);
		return intval($CountAgentClients->acnt);
	}


	public function Transactions()
	{
		$Transactions = mysqli_query($this->dbCon, "select * from sup_transactions");
		return $Transactions;
	}

	public function TransactionInfo($id)
	{
		$TransactionInfo = mysqli_query($this->dbCon, "select * from sup_transactions where id='$id' OR transid='$id'");
		$TransactionInfo = mysqli_fetch_object($TransactionInfo);
		return $TransactionInfo;
	}


	public function ClientInfo($id)
	{
		$ClientInfo = mysqli_query($this->dbCon, "select * from sup_clients where email='$id' OR id='$id' OR mobile='$id'");
		$ClientInfo = mysqli_fetch_object($ClientInfo);
		return $ClientInfo;
	}



	public function CreateClient($accid, $fullname, $email, $mobile)
	{
		$CreateClient = mysqli_query($this->dbCon, "INSERT INTO sup_clients(accid,fullname,email,mobile) VALUES('$accid','$fullname','$email','$mobile')");
		return $this->getLastId();
	}

	public function MyClients($accid)
	{
		$MyClients = mysqli_query($this->dbCon, "select * from sup_clients WHERE accid='$accid' ORDER BY id DESC");
		return $MyClients;
	}

	public function Clients()
	{
		$Clients = mysqli_query($this->dbCon, "select * from sup_clients ORDER BY id DESC");
		return $Clients;
	}





	public function HomeOdds($limit = 6)
	{
		$HomeOdds = mysqli_query($this->dbCon, "select * from sup_odds WHERE played=0");
		return $HomeOdds;
	}


	public function Odds()
	{
		$Odds = mysqli_query($this->dbCon, "select * from sup_odds WHERE played=0");
		return $Odds;
	}

	public function AdminOdds()
	{
		$Odds = mysqli_query($this->dbCon, "select * from sup_odds ORDER BY created DESC");
		return $Odds;
	}

	public function PlayedOdds()
	{
		$PlayedOdds = mysqli_query($this->dbCon, "select * from sup_odds WHERE played=1");
		return $PlayedOdds;
	}

	public function PlayedWinningOdds()
	{
		$PlayedWinningOdds = mysqli_query($this->dbCon, "select * from sup_odds WHERE played=1 AND win=1");
		return $PlayedWinningOdds;
	}

	
	public function UnPlayedOdds()
	{
		$PlayedOdds = mysqli_query($this->dbCon, "select * from sup_odds WHERE played=0");
		return $PlayedOdds;
	}



	public function OddsInfo($id)
	{
		$OddsInfo = mysqli_query($this->dbCon, "select * from sup_odds where id='$id'");
		$OddsInfo = mysqli_fetch_object($OddsInfo);
		return $OddsInfo;
	}

	public function LastOddId()
	{
		$LastOddId = mysqli_query($this->dbCon, "SELECT MAX(id) AS loid from sup_odds");
		$LastOddId = mysqli_fetch_object($LastOddId);
		return $LastOddId->loid;
	}



















	/** @return \mysqli_result|bool  */
	public  function SiteInfos()
	{
		$SiteInfos = mysqli_query($this->dbCon, "SELECT * FROM dati_siteinfo");
		return $SiteInfos;
	}

	/**
	 * @param mixed $name 
	 * @return mixed 
	 */
	public  function getSiteInfo($name)
	{
		$getSiteInfo = mysqli_query($this->dbCon, "SELECT `value` FROM dati_siteinfo WHERE name='$name'");
		$getSiteInfo = mysqli_fetch_object($getSiteInfo);
		return $getSiteInfo->value;
	}

	/**
	 * @param mixed $name 
	 * @param mixed $value 
	 * @return int 
	 */
	public  function setSiteInfo($name, $value)
	{
		mysqli_query($this->dbCon, "UPDATE dati_siteinfo SET value='$value' WHERE name='$name'");
		return $this->countAffected();
	}















	// Function to get the client IP address
	/** @return string|array|false  */
	public function getIP()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}


	// Admin//

}
