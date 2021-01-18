<?php
/*
CREDITS::
https://www.daggerhart.com/simple-php-template-class/
*/

namespace Apps;

use \Apps\Session;
use stdClass;

class Template extends Session
{

	public $variables = array();
	public $errors = array();

	public $Me = NULL;
	public $ME = NULL;
	public $Self = NULL;
	public $template = NULL;

	public $folder = "";
	public $root = templates_dir;
	public $templates_dir = templates_dir;
	public $templates_default = templates_default;
	public $templates_default_route = templates_default_route;

	public $public_dir = public_dir;
	public $assets = assets_dir;
	public $vendor = vendor_dir;
	public $bower_components = bower_dir;
	public $layouts = layouts_dir;
	public $store = store_dir;
	public $template_file = "";
	public $has_error = false;
	public $error = "";
	public $session = NULL;

	public $output = '';
	public $header_file = '';
	public $footer_file = '';
	public $robots = '';

	public $header_css_html = '';
	public $header_jss_html = '';
	public $header_asset_html = '';

	public $footer_css_html = '';
	public $footer_jss_html = '';
	public $footer_asset_html = '';

	public $header_jss_scripts = '';
	public $header_css_scripts = '';

	public $footer_jss_scripts = '';
	public $footer_css_scripts = '';



	public $tempArr = array();
	public $template_extension = template_file_extension;

	public $UIX = "";
	public $uix = "";
	public $uix_ver = "";
	public $token = NULL;
	public $encrypt_salt = encrypt_salt;

	public $session_timout = session_timout;
	public $auth = false;
	public $auth_url = auth_url;

	public $config = "";

	public function __construct($auth_url = NULL)
	{

		parent::__construct($auth_url);

		if (isset($this->data[auth_session_key])) {
			//user is logged in//
			if (isset($this->data['auth_time'])) {
				$s_now = strtotime(date('d-m-Y H:i:s'));
				$s_jvt = strtotime($this->data['auth_time']);
				$s_dif = $s_now - $s_jvt;
				//Check the session
				if ($s_dif <= ($this->session_timout * 60)) {
					$this->store('auth_time', date('d-m-Y H:i:s'));
					$this->auth = true;
					$this->store(auth_session_key, true);
				} else {
					$this->secure = false;
					$this->auth = false;
					$this->expired = (int)$this->expire();
				}
			}
			//user is logged in//
		}


		$this->set_folder($this->templates_dir);
		$config = get_defined_constants(true);

		$config_class = array();
		foreach ($config as $key => $value) {
			$config_class[$key] = $value;
		}

		$this->token = $this->tokenize();
		$this->config = $config_class;
		$this->Core = new Core;
	}


	public function authorize($accid = null)
	{
		if (!$this->data[auth_session_key]) {
			$this->store('auth_time', date('d-m-Y H:i:s'));
			$this->store('accid', $accid);
			$this->store(auth_session_key, true);
		}
	}


	public function __set($key, $val)
	{
		$this->variables[$key] = $val;
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->variables)) {
			return $this->variables[$key];
		}
		return false;
	}


	public function auth($url = NULL)
	{
		if ($this->auth) {
			$this->redirect($url);
		}
		return false;
	}


	public function setToast($route, $toast, $error = 'success')
	{
		$er_array = json_encode(array(
			"route" => $route,
			"toast" => $toast,
			"error" => $error
		));
		$this->store('toast', $er_array);
		$this->redirect($route);
	}



	public function addError($route,$error,$input_name=null,$input_val=null)
	{
		if (isset($this->data['errors'])) {
			$this->errors = $this->data['errors'];
		}
		$this->errors[$route][] = array(
			'error'=>$error,
			'input_name'=>$input_name,
			'input_val'=>$input_val
		);
		$this->store('errors', $this->errors);
		return $this->errors;
	}

	public function setError($route,$error,$input_name=null,$input_val=null)
	{
		if (isset($this->data['errors'])) {
			$this->errors = $this->data['errors'];
		}
		$this->errors[$route][] = array(
			'error'=>$error,
			'input_name'=>$input_name,
			'input_val'=>$input_val
		);
		$this->store('errors', $this->errors);
		$this->redirect($route);
		return true;
	}

	public function getError()
	{
		$htm = "";
		if (isset($this->data['errors'])) {
			$this->errors = $this->data['errors'];
		}
		$errClass = new stdClass;
		$errClass->count = count($this->errors);
		foreach ($this->errors as $err) {
			$htm .= "{$err}<br/>";
		}
		$errClass->error = $htm;
		return $errClass;
	}


	public function printError()
	{
		$htm = "";
		if (isset($this->data['errors'])) {
			$this->errors = $this->data['errors'];
		}
		foreach ($this->errors as $err) {
			$htm .= "{$err}<br/>";
		}
		$this->removedata("errors");
		return $htm;
	}



	public function getToast($route)
	{
		//$uri = $_SERVER['REQUEST_URI'];

		$toast = json_decode($this->data['toast']);
		$thtml = "";

		$thtml .= "<!-- toast center tap to close -->";
		$thtml .= "<div id=\"toast\" class=\"toast-box toast-center\">";
		$thtml .= "<ion-icon name=\"checkmark-circle\" class=\"text-{$toast->error}\"></ion-icon>";
		$thtml .= "<div class=\"text\">";
		$thtml .= "{$toast->toast}";
		$thtml .= "</div>";
		$thtml .= "</div>";
		$thtml .= "<button type=\"button\" class=\"btn btn-sm btn-text-light close-button\">CLOSE</button>";
		$thtml .= "</div>";
		$thtml .= "<!-- toast center tap to close -->";

		$this->removedata('toast');
		return $thtml;
	}

	public function set_folder($folder)
	{
		$this->folder = rtrim($folder, '/');
	}

	public function token($dtoken, $redir = "/auth/token")
	{
		$sess = new Session;
		$token = $sess->data['token'];
		$t_tik = $token->tik;
		$d_tik = $dtoken->tik;
		if ($d_tik != $t_tik) {
			$this->redirect("{$redir}?token={$token->token}");
		}
	}

	public function tokenize()
	{
		$otp = md5(sha1(time() . $this->encrypt_salt));
		$tiktok = new \stdClass;
		$html = "";

		$tik = time();
		$tok = sha1($tik . $this->encrypt_salt);
		$token = sha1($tik . $tok . $this->encrypt_salt);

		$html .= "<input type=\"hidden\" name=\"tik\" value=\"{$tik}\" /> \r\n";
		$html .= "<input type=\"hidden\" name=\"tok\" value=\"{$tok}\" /> \r\n";
		$html .= "<input type=\"hidden\" name=\"token\" value=\"{$otp}\" /> \r\n";

		$tiktok->tik = $tik;
		$tiktok->tik = $tik;
		$tiktok->tok = $tok;
		$tiktok->token = $token;

		$this->store("token", $tiktok);

		return $html;
	}



	public function error($error = "")
	{
		$this->error = $error;
		$this->has_error = true;
	}


	public function redirect($url = "/",$error=null,$mode="sucess")
	{
		if($error!=null){
			$this->errors = array(
				'route'=>$url,
				'error'=>$error,
				'mode'=>$mode,
			);
			$this->store('errors',$this->errors);
		}
		header("Location: {$url}");
		exit();
	}


	public function render($suggestions, $variables = array())
	{
		$template = $this->search_template($suggestions);
		$this->template_file = $suggestions;
		if ($template) {
			$output = $this->render_template($template, $variables);
		} else {
			$template = $this->search_template($this->templates_default);
			$output = $this->render_template($template, $variables);
		}
		return print($output);
	}

	public function SetupPage($suggestions, $variables = array())
	{

		$pagename = trim(strtolower($suggestions));
		$pagename = preg_replace('/\s+/', '', $pagename);
		$pagetitle = trim($suggestions);
		$pagetitle = str_replace('-', ' ', $pagetitle);
		$pagetitle = ucwords($pagetitle);
		$this->template_file = $suggestions;

		$template = $this->search_template($suggestions);
		if ($template) {
			$info = new \stdClass;
			$info->page = $pagename;
			$info->title = $pagetitle;
			return $info;
		} else {
			//Create dummy template file//
			$page_path = "{$this->templates_dir}";
			if (chmod($page_path, 0777)) {
				$page_save_path = "{$this->templates_dir}{$pagename}.{$this->template_extension}";
				$file = file_put_contents($page_save_path, "");
				$info = new \stdClass;
				$info->page = $pagename;
				$info->title = $pagetitle;
				return $info;
			}
		}
	}


	public function add($template, $show = true)
	{

		$suggestions_arr = explode(".", $template);
		$suggestions_arr_count = (int)count($suggestions_arr);
		$suggestions_arr_count_dir = (int)($suggestions_arr_count - 2);
		$suggestions_arr_count_file = (int)($suggestions_arr_count - 1);
		$suggestions_dir = '';
		for ($i = 0; $i <= $suggestions_arr_count_dir; ++$i) {
			$suggestions_dir .= "{$suggestions_arr[$i]}/";
		}
		$suggestions_dir = rtrim($suggestions_dir, '/');
		$suggestions = $suggestions_arr[$suggestions_arr_count_file];
		if (!is_array($suggestions)) {
			$suggestions = array($suggestions);
		}
		$suggestions = array_reverse($suggestions);
		$found = false;
		foreach ($suggestions as $suggestion) {
			$file = "{$this->folder}/{$suggestions_dir}/{$suggestion}.{$this->template_extension}";
			if (file_exists($file)) {
				if ($show) {
					require $file;
				}
				break;
			}
		}
	}

	public function addheader($header)
	{
		$header_arr = explode(".", $header);
		$header_arr_count = (int)count($header_arr);
		$header_arr_count_dir = (int)($header_arr_count - 2);
		$header_arr_count_file = (int)($header_arr_count - 1);
		$header_dir = '';
		for ($i = 0; $i <= $header_arr_count_dir; ++$i) {
			$header_dir .= "{$header_arr[$i]}/";
		}
		$header_dir = rtrim($header_dir, '/');
		$suggestions = $header_arr[$header_arr_count_file];
		if (!is_array($suggestions)) {
			$suggestions = array($suggestions);
		}
		$suggestions = array_reverse($suggestions);
		$found = false;
		foreach ($suggestions as $suggestion) {
			$file = "{$this->folder}/{$header_dir}/{$suggestion}.{$this->template_extension}";
			if (file_exists($file)) {
				$this->header_file = $file;
				break;
			}
		}
	}

	public function addfooter($footer)
	{
		$footer_arr = explode(".", $footer);
		$footer_arr_count = (int)count($footer_arr);
		$footer_arr_count_dir = (int)($footer_arr_count - 2);
		$footer_arr_count_file = (int)($footer_arr_count - 1);
		$footer_dir = '';
		for ($i = 0; $i <= $footer_arr_count_dir; ++$i) {
			$footer_dir .= "{$footer_arr[$i]}/";
		}
		$header_dir = rtrim($footer_dir, '/');
		$suggestions = $footer_arr[$footer_arr_count_file];
		if (!is_array($suggestions)) {
			$suggestions = array($suggestions);
		}
		$suggestions = array_reverse($suggestions);
		$found = false;
		foreach ($suggestions as $suggestion) {
			$file = "{$this->folder}/{$footer_dir}/{$suggestion}.{$this->template_extension}";
			if (file_exists($file)) {
				$this->footer_file = $file;
				break;
			}
		}
	}



	public function addcss($css_arr_data = array())
	{
		$header_html = "";
		if (is_array($css_arr_data)) {
			foreach ($css_arr_data as $css_file) {
				$processed_file = trim($css_file);
				$processed_file = ltrim($css_file, ".");
				$processed_file = ".{$processed_file}";
				if (file_exists($processed_file)) {
					$path_parts = pathinfo($processed_file);
					$ext = $path_parts["extension"];
					if ($ext == "css") {
						$this->header_css_html .= "<link rel=\"stylesheet\" href=\"{$processed_file}\">\r\n";
					}
				}
			}
		} else {
			$processed_file = trim($css_arr_data);
			$processed_file = ltrim($css_arr_data, ".");
			$processed_file = ".{$processed_file}";
			if (file_exists($processed_file)) {
				$path_parts = pathinfo($processed_file);
				$ext = $path_parts["extension"];
				if ($ext == "css") {
					$this->header_css_html .= "<link rel=\"stylesheet\" href=\"{$processed_file}\">\r\n";
				}
			}
		}
		return $this->header_css_html;
	}



	public function addasset($asset_arr_data = array(), $affix = NULL)
	{
		$header_html = "";
		if (is_array($asset_arr_data)) {
			foreach ($asset_arr_data as $asset_file) {
				$processed_file = trim($asset_file);
				$processed_file = ltrim($asset_file, ".");
				$processed_file = ".{$processed_file}";
				if (file_exists($processed_file)) {
					$path_parts = pathinfo($processed_file);
					$ext = $path_parts["extension"];
					if ($ext == "css") {
						$this->header_css_html .= "<link rel=\"stylesheet\" href=\"{$processed_file}\">\r\n";
					} elseif ($ext == "js") {
						$header_html .= "<script src=\"{$processed_file}\"></script>\r\n";
					} elseif ($ext == "php") {
					} else {
					}
				}
			}
		} else {
			$processed_file = trim($asset_arr_data);
			$processed_file = ltrim($asset_arr_data, ".");
			$processed_file = ".{$processed_file}";
			if (file_exists($processed_file)) {
				$path_parts = pathinfo($processed_file);
				$ext = $path_parts["extension"];
				if ($ext == "css") {
					$header_html .= "<link rel=\"stylesheet\" href=\"{$processed_file}\">\r\n";
				} elseif ($ext == "js") {
					$header_html .= "<script src=\"{$processed_file}\"></script>\r\n";
				} elseif ($ext == "php") {
				} else {
				}
			}
		}
		$this->header_css_html .= $header_html;
		return $this->header_css_html;
	}



	public function addjs($jss_arr_data = array())
	{
		$jss_html = "";
		if (is_array($jss_arr_data)) {
			foreach ($jss_arr_data as $jss_file) {
				$processed_file = trim($jss_file);
				$processed_file = ltrim($jss_file, ".");
				$processed_file = ".{$processed_file}";
				if (file_exists($processed_file)) {
					$path_parts = pathinfo($processed_file);
					$ext = $path_parts["extension"];
					if ($ext == "js") {
						$this->footer_jss_html .= "<script src=\"{$processed_file}\"></script>\r\n";
					}
				}
			}
		} else {
			$processed_file = trim($jss_arr_data);
			$processed_file = ltrim($jss_arr_data, ".");
			$processed_file = ".{$processed_file}";
			if (file_exists($processed_file)) {
				$path_parts = pathinfo($processed_file);
				$ext = $path_parts["extension"];
				if ($ext == "js") {
					$this->footer_jss_html .= "<script src=\"{$processed_file}\"></script>\r\n";
				}
			}
		}
		return $this->footer_jss_html;
	}

	public function addjQuery($scripts)
	{
		$qjss_html = "<script type=\"text/javascript\" async=\"true\" runat=\"server\" language=\"javascript\">\r\n";
		$qjss_html .= "(function( $ ){\r\n";
		$qjss_html .= $scripts;
		$qjss_html .= "});\r\n";
		$qjss_html .= "</script>\r\n";
		$this->footer_jss_scripts .= $qjss_html;
		return $qjss_html;
	}

	public function LoadHeader($domain = domain)
	{
		$header_output = "<base href=\"{$domain}\"> \r\n";
		$header_output .= "{$this->robots} \r\n";
		$header_output .= "{$this->header_css_html} \r\n";
		$header_output .= "{$this->header_asset_html} \r\n";
		$header_output .= "{$this->header_jss_scripts} \r\n";
		echo $header_output;
	}

	public function LoadFooter()
	{
		$footer_output = "";
		$footer_output .= "{$this->footer_jss_html} \r\n";
		$footer_output .= "{$this->footer_asset_html} \r\n";
		$footer_output .= "{$this->footer_jss_scripts} \r\n";
		echo $footer_output;
	}

	public function robot($name, $content)
	{
		$_name = $name;
		$_contents = explode(",", $content);
		foreach ($_contents as $_item) {
			$this->robots .= "<meta name=\"{$_name}\" content=\"{$_item}\" />\r\n";
		}
		return true;
	}

	public function assign($arrKey, $arrVal)
	{
		$this->tempArr[$arrKey] = $arrVal;
	}

	public function find_template($suggestions)
	{
		if (!is_array($suggestions)) {
			$suggestions = array($suggestions);
		}
		$suggestions = array_reverse($suggestions);
		$found = false;
		foreach ($suggestions as $suggestion) {
			$file = "{$this->folder}/{$suggestion}.{$this->template_extension}";
			if (file_exists($file)) {
				$found = $file;
				break;
			}
		}
		return $found;
	}


	public function search_template($teplate)
	{

		$template_arr = explode(".", $teplate);
		$template_arr_count = (int)count($template_arr);
		$template_arr_count_dir = (int)($template_arr_count - 2);
		$template_arr_count_file = (int)($template_arr_count - 1);
		$template_dir = '';
		for ($i = 0; $i <= $template_arr_count_dir; ++$i) {
			$template_dir .= "{$template_arr[$i]}/";
		}
		$template_dir = rtrim($template_dir, '/');
		$suggestions = $template_arr[$template_arr_count_file];

		if (!is_array($suggestions)) {
			$suggestions = array($suggestions);
		}
		$suggestions = array_reverse($suggestions);
		$found = false;
		foreach ($suggestions as $suggestion) {
			$file = "{$this->folder}/{$template_dir}/{$suggestion}.{$this->template_extension}";
			if (file_exists($file)) {
				$found = $file;
				break;
			}
		}
		return $found;
	}



	public function render_template($template, $variables)
	{
		ob_start();
		foreach (func_get_args()[1] as $key => $value) {
			${$key} = $value;
		}
		foreach ($this->tempArr as $key => $value) {
			${$key} = $value;
		}

		$config = $this->config;

		$Me = $this;
		$ME = $this;
		$Self = $this;
		$Template = $this;

		$error = $this->error;
		$has_error = $this->has_error;
		$root = $this->root;
		$assets = $this->assets;
		$bower_components = $this->bower_components;
		$token = $this->token;
		$layouts = $this->layouts;
		$store = $this->store;
		$template_file = $this->template_file;
		$public_dir = $this->public_dir;
		$templates_dir = $this->templates_dir;
		$header_files = "";
		$robots = $this->robots;
		$footer_files = "";
		$Core = $this->Core;
		//Load Config variables//
		$config = $this->config;
		//Load Config variables//

		//Wrap Header//
		if (file_exists($this->header_file)) {
			include $this->header_file;
		}
		include func_get_args()[0];
		if (file_exists($this->footer_file)) {
			include $this->footer_file;
		}
		//Wrap Footer//

		return ob_get_clean();
	}
}
