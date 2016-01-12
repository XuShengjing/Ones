<?php
use Ones\ControllerRouter;
class ControllerRouterTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @dataProvider removeSplashProvider
	 */
	function testRemoveSplash($path, $actual){
		$router = new ControllerRouter("");
		$path = $router->removeAdditionalSplash($path);
		$this->assertEquals($path,$actual);
	}
	
	public function removeSplashProvider()
	{
		return array(
				array("/home/index/","home/index"),
				array("/home//index/","home/index"),
				array("/home///index/","home/index"),
				array("///home///index//","home/index"),
		);
	}
	
	
	
	function testHomeIndex(){
		$testdata_dir = __DIR__."/testdata";
		$router = new ControllerRouter($testdata_dir."/mvc/controller");
		
		
		$home_paths = array(
				"/home",
				"/home/",
				"/home/index",
				"/home/index/",
// 				"/home//index/",
// 				"/home///index/",
// 				"//home///index//",
		);
		
		foreach ($home_paths as $home_path){
			$result = $router->getCallable($home_path);
			$this->assertNotEmpty($result, $home_path);
			$this->assertEquals("home", get_class($result[0]));
			$this->assertEquals("index", $result[1]);
		}
	}
	
	function testSubFolder(){
		$testdata_dir = __DIR__."/testdata";
		$router = new ControllerRouter($testdata_dir."/mvc/controller");
	
	
		$home_paths = array(
				"/subfolder/subfoldercontroller",
				"/subfolder/subfoldercontroller/index",
				"/subfolder/subfoldercontroller/index/",
				"/subfolder/subfoldercontroller/",
// 				"/subfolder//subfoldercontroller/idnex/",
// 				"/subfolder///subfoldercontroller///idnex/",
// 				"///subfolder///subfoldercontroller///idnex/",
		);
	
		foreach ($home_paths as $home_path){
			$result = $router->getCallable($home_path);
			$this->assertNotEmpty($result,$home_path);
			$this->assertEquals("subfoldercontroller", get_class($result[0]));
			$this->assertEquals("index", $result[1]);
		}
	}
	
	function test404Path(){
		$testdata_dir = __DIR__."/testdata";
		$router = new ControllerRouter($testdata_dir."/mvc/controller");
	
	
		$home_paths = array(
				"/notexist/subfoldercontroller",
				"/notexist/subfoldercontroller/idnex",
				"/notexist/subfoldercontroller/idnex/",
				"/notexist/subfoldercontroller/",
				"/notexist//subfoldercontroller/idnex/",
				"/notexist///subfoldercontroller///idnex/",
				"///notexist///subfoldercontroller///idnex/",
		);
	
		foreach ($home_paths as $home_path){
			$result = $router->getCallable($home_path);
			$this->assertNull($result);
		}
	}
	
	
	
}