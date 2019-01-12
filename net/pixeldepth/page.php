<?php

namespace net\pixeldepth;

class Page {

	protected $pdo;
	protected $twig;
	protected $twig_loader;

	protected $route;
	protected $sub_route;

	public function __construct($twig, $twig_loader){
		$this -> twig = $twig;
		$this -> twig_loader = $twig_loader;

		$this -> route = Request_Listener :: $action;
		$this -> sub_route = Request_Listener :: $page;

		$this -> twig -> addGlobal("route", Request_Listener :: $action);
		$this -> twig -> addGlobal("sub_route", Request_Listener :: $page);
	}

	public function set_title($title = ""){
		$this -> twig -> addGlobal("title", " - " . $title);
	}

	public function show_error($msg = "", $title = ""){
		if(empty($title)){
			$title = "An Error Has Occurred";
		}

		$this -> set_title($title);

		$this -> twig -> display("lib/error.html", array(

			"message" => $msg

		));
	}

}