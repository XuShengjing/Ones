<?php
namespace Ones;

class ViewLoader{
	
	protected $base_dir;
	function __construct($base_dir){
		$this->base_dir = $base_dir;
	}
	
	function setBaseDir($base_dir){
		$this->base_dir = $base_dir;
	}
	
	function loadView($view_name, $view_data, $return = false){
		extract($view_data);
		ob_start();
		include("{$base_dir}/{$view}.php");
		$buffer = ob_get_contents();
		@ob_end_clean();
		echo $buffer;
	}
}