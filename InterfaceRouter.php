<?php
namespace Ones;

interface InterfaceRouter{
	
	/**
	 * get the callable by http path info
	 * @param string $path The path info such as "/", "/a/b"
	 */
	function getCallable($path);
}