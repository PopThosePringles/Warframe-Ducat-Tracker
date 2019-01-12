<?php

namespace net\pixeldepth\warframe;

use net\pixeldepth\Utils;
use net\pixeldepth\Page;
use net\pixeldepth\Request_Listener;

require_once(ROOT_PATH . "vendor/autoload.php");

final class Warframe {

	public static $twig;
	public static $twig_loader;

	static function init(){
		self :: setup_twig();

		Request_Listener :: listen();
	}

	static function setup_twig(){
		self :: $twig_loader = new \Twig_Loader_Filesystem(ROOT_PATH . "templates");
		self :: $twig = new \Twig_Environment(self :: $twig_loader, array(

			"cache" => ROOT_PATH . "cache",
			"auto_reload" => true

		));
	}

}