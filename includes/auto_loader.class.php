<?php

class Auto_Loader {

	public static function register(){
		spl_autoload_register(array("Auto_Loader", "load_class"));
	}
	
	public static function load_class($klass){
		$file = self :: get_file_path(strtolower($klass));

		if($file && file_exists($file)){
			require_once($file);
		}
	}

	public static function get_file_path($klass){
		$len = strlen(NAMESPACE_PREFIX);

		if(strncmp(NAMESPACE_PREFIX, $klass, $len) != 0){
			return null;
		}

		$rel_klass = substr($klass, $len);

		return NAMESPACE_DIR . str_replace("\\", DIRECTORY_SEPARATOR, $rel_klass) . ".php";
	}
	
}

Auto_Loader :: register();