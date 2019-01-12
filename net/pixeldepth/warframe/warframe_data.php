<?php

namespace net\pixeldepth\warframe;

class Warframe_Data {

	public static $lith = "https://warframe.fandom.com/wiki/Ducats/Prices/Lith";
	public static $meso = "https://warframe.fandom.com/wiki/Ducats/Prices/Meso";
	public static $neo = "https://warframe.fandom.com/wiki/Ducats/Prices/Neo";
	public static $axe = "https://warframe.fandom.com/wiki/Ducats/Prices/Axi";

	public static function fetch_ducat_data(){
		if(!file_exists(DATA_PATH . "lith_ducats.data")){
			file_put_contents(DATA_PATH . "lith_ducats.data", file_get_contents(self :: $lith));
		}

		if(!file_exists(DATA_PATH . "meso_ducats.data")){
			file_put_contents(DATA_PATH . "meso_ducats.data", file_get_contents(self :: $meso));
		}

		if(!file_exists(DATA_PATH . "neo_ducats.data")){
			file_put_contents(DATA_PATH . "neo_ducats.data", file_get_contents(self :: $neo));
		}

		if(!file_exists(DATA_PATH . "axi_ducats.data")){
			file_put_contents(DATA_PATH . "axi_ducats.data", file_get_contents(self :: $axe));
		}
	}

	public static function fetch_data($fetch_ducat_data = false){
		if($fetch_ducat_data){
			self :: fetch_ducat_data();
		}

		self :: create_data("lith");
		self :: create_data("meso");
		self :: create_data("neo");
		self :: create_data("axi");
	}

	public static function create_data($type = "lith"){
		$dom = new \DOMDocument();
		$internal_errors = libxml_use_internal_errors(true);

		$html = file_get_contents(DATA_PATH . $type . "_ducats.data");
		$dom -> loadHTML($html);

		libxml_use_internal_errors($internal_errors);

		$tables = $dom -> getElementsByTagName("table");

		$output = array();

		foreach($tables as $table){
			if(strpos($table -> getAttribute("class"), "listtable") !== false){
				$rows = $table -> getElementsByTagName("tr");
				$count = 0;

				foreach($rows as $row){
					if($count > 0){
						$cells = $row -> getElementsByTagName("td");

						if($cells -> length != 3){
							continue 2;
						}

						$part = $cells -> item(0) -> nodeValue;
						$location_nodes = $cells -> item(1) -> childNodes;
						$ducats = $cells -> item(2) -> nodeValue;

						$relics = array();

						for($i = 0; $i < $location_nodes -> length; ++ $i){
							$node = $location_nodes -> item($i);

							if($node -> nodeName == "span"){
								if(preg_match("/" . ucwords($type) . " (\w+)/i", $node -> nodeValue, $matches)){
									$valuted = false;

									if(strstr($location_nodes -> item($i + 1) -> nodeValue, "(") !== false){
										$valuted = true;
									}

									$rarity = rtrim(trim(str_replace(" (", "", $location_nodes -> item($i + 1) -> nodeValue)));

									$relics[] = array(

										"name" => $matches[1],
										"rarity" => strtolower($rarity),
										"vaulted" => $valuted

									);
								}
							}
						}

						//print_r($relics);

						foreach($relics as $relic){
							if(!isset($output[$relic["name"]])){
								$output[$relic["name"]] = array();
							}

							$output[$relic["name"]][] = array(

								"name" => str_replace(" Blueprint", " Bp", $part),
								"ducats" => $ducats,
								"rarity" => $relic["rarity"],
								"vaulted" => $relic["vaulted"]

							);
						}

						//break;
					}


					$count ++;
				}
			}
		}

		file_put_contents(DATA_PATH . $type . ".json", json_encode($output));
	}

}