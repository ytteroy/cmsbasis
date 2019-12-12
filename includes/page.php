<?php
class page {
	private $page_content;
	public $theme_file;
	private $page_title;
	public $full_page = false;
	public $print_page;
	public $theme_url;
	public $theme_path;
	
	function __construct($print=true){
		$this->print_page = $print;
	}
	
	function set_theme($file){
		$this->theme_file = $file;
		$this->theme_path = str_replace('/index.php', '', $this->theme_file);
		$this->theme_url = str_replace(BASE_PATH, SITE_URL, $this->theme_path);
	}
  
	function must_login(){
		if(!IS_USER){
			redirect('/login');
		}
	}
	
	function must_have_permission($permission){
		global $users;
		if(!$users->has_permission($permission)){
			redirect('/login');
		}
	}
	
	function set_page_content($content, $force = false){
		if(!$this->page_content OR $force){
			$this->page_content = $content;
		}
	}
	
	function get_page_content(){
		return $this->page_content;
	}
	
	function get_loading(){
		global $start_time;
		$starttime = $start_time;
		$endtime = microtime();
		$endarray = explode(" ", $endtime);
		$endtime = $endarray[1] + $endarray[0];
		$totaltime = $endtime - $starttime;
		$totaltime = round($totaltime, 5);
		return $totaltime;
	}
	
	function __destruct(){   
		if($this->print_page)
		require $this->theme_file;
	}
	
	function set_page_title($title, $force = false){
		if(!$this->page_title OR $force)
			$this->page_title = $title;  
	}
	
	function get_page_title(){
		return $this->page_title;
	}
	
	function set_full_page(){
		$this->full_page = true;
	}
	
	function get_full_page(){
		return $this->full_page;
	}
}