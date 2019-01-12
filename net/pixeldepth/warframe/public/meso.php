<?php

use net\pixeldepth\Page;

class Meso extends Page {

	private $template = "relics.html";

	public function init(){
		$relics = json_decode(file_get_contents(DATA_PATH . "meso.json"), true);

		ksort($relics);

		$this -> twig -> display($this -> template, array(

			"relic_type" => "meso",
			"relics" => $relics

		));
	}

}