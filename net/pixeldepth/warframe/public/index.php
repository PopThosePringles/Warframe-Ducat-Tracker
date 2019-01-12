<?php

use net\pixeldepth\Page;

class Index extends Page {

	private $template = "relics.html";

	public function init(){
		$relics = json_decode(file_get_contents(DATA_PATH . "lith.json"), true);

		ksort($relics);

		$this -> twig -> display($this -> template, array(

			"relic_type" => "lith",
			"relics" => $relics

		));
	}

}