<?php namespace Buchin\SearchTerm;

/**
* SearchTer
*/
class SearchTerm
{
	public static function get($referer = null)
	{
		$referer = self::setReferer($referer);

		if(empty($referer)){
			return '';
		}

		if(!self::isCameFromSearchEngine($referer)){
			return '';
		}

		$query = explode("q=", $referer);


		if(!isset($query[1])){
			return '';
		}

		$query[1] = 'q=' . $query[1];
		parse_str($query[1], $output);

		if(!isset($output['q'])){
			return '';
		}

		return $output['q'];

	}

	public static function setReferer($referer)
	{
		if(is_null($referer)){
			$referer = '';
			
			if(isset($_SERVER['HTTP_REFERER'])){
				$referer = $_SERVER['HTTP_REFERER'];
			}
		}

		return $referer;
	}

	public static function isCameFromSearchEngine($referer = null)
	{		
		$referer = self::setReferer($referer);
		
		if(empty($referer)){
			return false;
		}

		if(self::str_contains($referer, '.google.') || self::str_contains($referer, '.bing.')){
			return true;
		}

		return false;
	}

	public static function str_contains($haystack, $needle, $ignoreCase = true) {
	    if ($ignoreCase) {
	        $haystack = strtolower($haystack);
	        $needle   = strtolower($needle);
	    }

	    $needlePos = strpos($haystack, $needle);
	    return ($needlePos === false ? false : ($needlePos+1));
	}
}