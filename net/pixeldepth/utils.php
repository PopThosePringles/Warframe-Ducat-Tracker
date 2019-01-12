<?php

namespace net\pixeldepth;

class Utils {

	public static function clean_get(){
		if(is_array($_GET) && count($_GET)){
			foreach($_GET as $key => $value){
				unset($_GET[$key]);

				if(is_array($value)){
					foreach($value as $k => $v){
						$v = preg_replace("/[^\w\+\?\[\]\.\/\_\-\s]+/", "", urldecode($v));
						$_GET[strtolower($key)][$k] = $v;
					}
				} else {
					$value = preg_replace("/[^\w\+\?\[\]\.\/\-\s]+/", "", urldecode($value));
					$_GET[strtolower($key)] = $value;
				}
			}
		}
	}

	/**
	 * Does safe cleaning
	 *
	 * @param String $value - The value to be cleaned
	 * @return String - The cleaned string returned back
	 */

	public static function safe_clean($value = ""){
		$value = preg_replace("/[^\w\+\?\[\]\.\/]+/", "", $value);

		return $value;
	}

	public static function strict_clean($value = ""){
		$value = preg_replace("/[^\w]+/", "", $value);

		return $value;
	}

	public static function go($url = ""){
		@header("Location: " . $url);
		exit();
	}

	public static function str_shorten($str = "", $len = 0){
		if($str && $len){
			if(strlen($str) >= intval($len)){
				$str = substr($str, 0, $len) . "...";
			}
		}

		return $str;
	}

	public static function format_bytes($size = 0){
		$units = array(" B", " KB", " MB", " GB", " TB");

		for($i = 0; $size >= 1024 && $i < 4; $i ++){
			$size /= 1024;
		}

		return round($size, 2) . $units[$i];
	}

	public static function html_entities($str = "", $decode = true){
		if(is_string($str)){
			if($decode){
				$str = html_entity_decode($str, ENT_QUOTES, "UTF-8");
			}

			return htmlentities($str, ENT_QUOTES, "UTF-8");
		}

		return $str;
	}

	public static function html_entities_decode($str = ""){
		if(is_string($str)){
			return html_entity_decode($str, ENT_QUOTES, "UTF-8");
		}

		return $str;
	}

	/**
	 * Returns a cookie if exists
	 *
	 * @param $cookie_name Boolean
	 * @return Boolean
	 */

	public static function get_cookie($cookie_name = false){
		if($cookie_name){
			if(is_array($_COOKIE) && isset($_COOKIE[$cookie_name])){
				$_COOKIE[$cookie_name] = preg_replace("/^[^\w]+$/", "", urldecode($_COOKIE[$cookie_name]));
				return $_COOKIE[$cookie_name];
			}
		}

		return "";
	}

	public static function isset_cookie($cookie_name = false){
		if($cookie_name){
			if(is_array($_COOKIE) && isset($_COOKIE[$cookie_name])){
				return true;
			}
		}

		return false;
	}

	/**
	 * Sets a cookie
	 *
	 * @param $cookie_name String - Name of the cookie to be stored
	 * @param $cookie_value String - Value of the cookie
	 * @param $keep Boolean - Set to true to keep cookie for a very long time
	 * @param $expiry Integer - Set an expiry time for the cookie
	 * @param $path String - Cookie path
	 * @param $domain String - Cookie domain
	 * @param $secure Boolean - Use in secure only
	 * @param $httponly Boolean - Hide cookie, this is set to true by default
	 * @return Boolean
	 */

	public static function set_cookie($cookie_name = "", $cookie_value = "", $keep = false, $expiry = false, $path = "/", $domain = "", $secure = false, $httponly = true){
		if($cookie_name){
			$cookie_name = preg_replace("/^[^\w]+$/", "", $cookie_name);
			$cookie_value = preg_replace("/^[^\w]+$/", "", $cookie_value);

			// Lets do the expiry, default will only last for the session

			$expire = ($keep)? (($expiry)? $expiry : (time() + (60 * 60 * 24 * 365 * 15))) : 0;

			// Set the cookie

			if(setcookie($cookie_name, $cookie_value, $expire, $path, $domain, $secure, $httponly)){
				return true;
			}
		}

		return false;
	}

	/**
	 * Deletes a cookie by setting the expiry time to the past
	 *
	 * @param String - Cookie name
	 */

	public static function delete_cookie($cookie = null){
		self :: set_cookie($cookie, "", false, (time() - 5000));
	}

	/**
	 * Set a session var
	 *
	 * @param $key String
	 * @param $value String
	 * @return Boolean
	 */

	public static function set_session($key = null, $value = ""){
		if($key){
			$_SESSION[$key] = $value;
			return true;
		}

		return false;
	}

	/**
	 * Delete a session var
	 *
	 * @param $key String
	 * @return Boolean
	 */

	public static function delete_session($key = null){
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
			return true;
		}

		return false;
	}

	/**
	 * Get a session var
	 *
	 * @param $key String
	 * @return String|Boolean
	 */

	public static function get_session($key = null){
		if($key && isset($_SESSION[$key])){
			return $_SESSION[$key];
		}

		return false;
	}

	public static function isset_session($key = null){
		if($key && isset($_SESSION[$key])){
			return true;
		}

		return false;
	}

}