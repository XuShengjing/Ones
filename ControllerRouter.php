<?php
namespace Ones;

class ControllerRouter{
	protected $base_dir;
	function __construct($base_dir){
		$this->base_dir = $base_dir;
	}
	
	/**
	 * 通过url的path info获取回调方法
	 * @param unknown $path
	 */
	function getCallable($path){
		
		//去除路径中多余的斜杠
		$path = preg_replace('/\/+/', "/", $path);
		if($path === '/'){
			$path = '/home/index';
		}
		//去除头尾的斜杠
		$path = trim($path,"/");
		
		//找到对应的控制器类，路径中的最后一个节点为方法，
		//比如"/a/b/c"的控制器类为b, c为对应的方法， 所在的路径为"application/a/b.php",
		$file_path = "{$this->base_dir}/{$path}.php";
		
		//如果直接是文件，那么对应index方法
		if(is_file("{$this->base_dir}/{$path}.php")){
			$method_name = "index";
			$segments = explode("/", $path);
			$class_name = array_pop($segments);
		}
		
		else{
			$segments = explode("/", $path);
			$method_name = array_pop($segments);
			$file_path = $this->base_dir."/".join("/", $segments).".php";
			$class_name = array_pop($segments);
		}
		require_once $file_path;
		if(class_exists($class_name) && method_exists($class_name, $method_name)){
			$obj = new $class_name();
			return array($obj,$method_name);
		}
		else{
			return null;
		}
		
	}
}