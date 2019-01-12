<?php

use net\pixeldepth\Page;

class Neo extends Page {

	private $template = "relics.html";

	public function init(){
		$relics = json_decode(file_get_contents(DATA_PATH . "neo.json"), true);

		ksort($relics);

		$this -> twig -> display($this -> template, array(

			"relic_type" => "neo",
			"relics" => $relics

		));
	}

}