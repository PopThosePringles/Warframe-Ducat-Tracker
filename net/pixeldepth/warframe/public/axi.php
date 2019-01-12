<?php

use net\pixeldepth\Page;

class Axi extends Page {

	private $template = "relics.html";

	public function init(){
		$relics = json_decode(file_get_contents(DATA_PATH . "axi.json"), true);

		ksort($relics);

		$this -> twig -> display($this -> template, array(

			"relic_type" => "axi",
			"relics" => $relics

		));
	}

}