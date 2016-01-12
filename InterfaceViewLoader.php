<?php
namespace Ones;

interface InterfaceViewLoader{
	function loadView($view_name, $view_data, $return = false);
}