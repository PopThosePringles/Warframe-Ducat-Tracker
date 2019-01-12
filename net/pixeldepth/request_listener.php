<?php

namespace net\pixeldepth;

use net\pixeldepth\warframe\Warframe;

final class Request_Listener {

	public static $action = "";
	public static $page = "";

	public static function listen(){
		Utils :: clean_get();

		self :: get_action();
		self :: get_page();
		self :: monitor();
	}

	private static function get_action(){
		if(isset($_GET["action"])){
			self :: $action = strtolower(Utils :: strict_clean(str_replace("-", "_", $_GET["action"])));
		}
	}

	private static function get_page(){
		if(isset($_GET["page"])){
			self :: $page = strtolower(Utils :: strict_clean(str_replace("-", "_", $_GET["page"])));
		}
	}

	private static function monitor(){

		/**
		 * Each action loads a class, so we will check to see
		 * if a class exists first
		 */

		$class = (empty(self :: $action))? "index" : self :: $action;
		$path = ($class == "admin")? PRIVATE_PATH : PUBLIC_PATH;
		$default = $path . "index.php";
		$path .= $class . ".php";

		if($class == "admin" && isset(self :: $page) && !empty(self :: $page)){
			$path = PRIVATE_PATH . self :: $page . ".php";
			$class = self :: $page;
		}

		if(!file_exists($path)){
			if(file_exists($default)){
				$path = $default;
				$class = "index";
			} else {
				$path = $class = false;
			}
		}

		if($path){
			$class_name = ucwords($class);

			if($class_name){
				require_once($path);

				if(class_exists($class_name)){
					$klass = new $class_name(Warframe :: $twig, Warframe :: $twig_loader);

					if(method_exists($klass, "init")){
						$klass -> init();
					}

					return;
				}
			}
		}

		exit();
	}

}