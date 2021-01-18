<?php

namespace Apps;

class EmailTemplate{

	public $variables = array();
    public $path_to_file= array();

	public $root = templates_dir;
	public $templates_dir = templates_dir;
	public $public_dir = public_dir;
	public $template_file = "";
	public $folder = '';
	public $template_extension = template_file_extension;

    function __construct($suggestions){
		$this->set_folder( $this->templates_dir );
		$template = $this->search_template( $suggestions );
		$this->template_file = $template;
		$this->path_to_file = $template;
    }

	public function set_folder( $folder ){
		$this->folder = rtrim( $folder, '/' );
	}	

    public function __set($key,$val){
        $this->variables[$key] = $val;
    }

	public function search_template( $template ){
		
		$template_arr = explode(".",$template);
		$template_arr_count = (int)count($template_arr);
		$template_arr_count_dir = (int)($template_arr_count - 2);
		$template_arr_count_file = (int)($template_arr_count - 1);
		$template_dir = '';
		for( $i=0;$i<=$template_arr_count_dir; ++$i){
			$template_dir .= "{$template_arr[$i]}/";
		}
		$template_dir = rtrim( $template_dir, '/' );
		$suggestions = $template_arr[$template_arr_count_file];
		
		if ( !is_array( $suggestions ) ) {
			$suggestions = array( $suggestions );
		}
		$suggestions = array_reverse( $suggestions );
		$found = false;
		foreach( $suggestions as $suggestion ){
			$file = "{$this->folder}/{$template_dir}/{$suggestion}.{$this->template_extension}";
			if ( file_exists( $file ) ){
				$found = $file;
				break ;
			}
		}
		return $found;
	}

    public function compile(){
        ob_start();
        extract($this->variables);
        include $this->template_file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
	
	
	
}
	
	

	
	
?>