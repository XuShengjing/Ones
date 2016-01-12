<?php
namespace Ones;

class OnesApp{
	
	/**
	 * 
	 * @var InterfaceRouter
	 */
	protected $router;
	
	/**
	 * 
	 * @var InterfaceViewLoader
	 */
	protected $view_loader;
	
	
	static $instance = null;
	
	public static getInstance(){
		if(self::$instance  == null){
			self::$instance = new OnesApp();
		}
	}
	
	function setRouter(InterfaceRouter $router){
		$this->router = $router;
	}
	
	function setViewLoader(InterfaceViewLoader $view_loader){
		$this->view_loader = $view_loader;
	}
	
	function runInWebServer($baseDir){
		if(!$this->router){
			$controller_dir = $baseDir."/controller";
			$this->router = new ControllerRouter($controller_dir);
		}
		if(!$this->view_loader){
			$view_dir = $baseDir."/view";
			$this->router = new ViewLoader($view_dir);
		}
		
		$path = $_SERVER['PATH_INFO'];
		$callable = $this->router->getCallable($path);
		if($callable){
			call_user_func($callable);
		}
	}
}