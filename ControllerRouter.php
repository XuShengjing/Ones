<?php
namespace Ones;

class ControllerRouter{
	protected $base_dir;
	function __construct($base_dir){
		$this->base_dir = $base_dir;
	}
	
	/**
	 * ͨ��url��path info��ȡ�ص�����
	 * @param unknown $path
	 */
	function getCallable($path){
		
		//ȥ��·���ж����б��
		$path = preg_replace('/\/+/', "/", $path);
		if($path === '/'){
			$path = '/home/index';
		}
		//ȥ��ͷβ��б��
		$path = trim($path,"/");
		
		//�ҵ���Ӧ�Ŀ������࣬·���е����һ���ڵ�Ϊ������
		//����"/a/b/c"�Ŀ�������Ϊb, cΪ��Ӧ�ķ����� ���ڵ�·��Ϊ"application/a/b.php",
		$file_path = "{$this->base_dir}/{$path}.php";
		
		//���ֱ�����ļ�����ô��Ӧindex����
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