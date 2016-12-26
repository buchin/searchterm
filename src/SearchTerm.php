<?php namespace Buchin\SearchTerm;

/**
* SearchTer
*/
class SearchTerm
{
	public static function get($referer = null)
	{

		if(is_null($referer)){
			$referer = $_SERVER['HTTP_REFERER'];
		}

		
		if(empty($referer)){
			return false;
		}

		$host = self::getHost($referer);

		if(!$host){
			return false;
		}

		$delimiter = self::getDelimiter($host);

		if(!$delimiter){
			return false;
		}

		return self::getTerms($delimiter, $referer);
	}

	public static function getHost($referer) {	    
	    $referer_info = parse_url($referer);
	    $referer = $referer_info['host'];

	    // Remove www. is it exists
	    if(substr($referer, 0, 4) == 'www.')
	        $referer = substr($referer, 4);

	    return $referer;
	}

	public static function getDelimiter($ref) {
	    // Search engine match array
	    // Used for fast delimiter lookup for single host search engines.
	    // Non .com Google/MSN/Yahoo referrals are checked for after this array is checked
	    $search_engines = array(
	    	'google.com' => 'q',
			'go.google.com' => 'q',
			'maps.google.com' => 'q',
			'local.google.com' => 'q',
			'search.yahoo.com' => 'p',
			'search.msn.com' => 'q',
			'bing.com' => 'q',
			'msxml.excite.com' => 'qkw',
			'search.lycos.com' => 'query',
			'alltheweb.com' => 'q',
			'search.aol.com' => 'query',
			'search.iwon.com' => 'searchfor',
			'ask.com' => 'q',
			'ask.co.uk' => 'ask',
			'search.cometsystems.com' => 'qry',
			'hotbot.com' => 'query',
			'overture.com' => 'Keywords',
			'metacrawler.com' => 'qkw',
			'search.netscape.com' => 'query',
			'looksmart.com' => 'key',
			'dpxml.webcrawler.com' => 'qkw',
			'search.earthlink.net' => 'q',
			'search.viewpoint.com' => 'k',
			'mamma.com' => 'query'
		);

	    $delim = false;

	    // Check to see if we have a host match in our lookup array
	    if (isset($search_engines[$ref])) {

	        $delim = $search_engines[$ref];

	    } else {
	        // Lets check for referrals for international TLDs and sites with strange formats
	        // Optimizations
	        $sub13 = substr($ref, 0, 13);
	        // Search string for engine
	        if(substr($ref, 0, 7) == 'google.')
	            $delim = "q";
	        elseif($sub13 == 'search.atomz.')
	            $delim = "sp-q";
	        elseif(substr($ref, 0, 11) == 'search.msn.')
	            $delim = "q";
	        elseif($sub13 == 'search.yahoo.')
	            $delim = "p";
	        elseif(preg_match('/home\.bellsouth\.net\/s\/s\.dll/i', $ref))
	            $delim = "bellsouth";
	    }

	    return $delim;
	}

	public static function getTerms($d, $referer) {

	    $terms       = null;
	    $query_array = array();
	    $query_terms = null;

	    // Get raw query
	    $query = explode($d.'=', $referer);
	    $query = explode('&', $query[1]);
	    $query = urldecode($query[0]);

	    // Remove quotes, split into words, and format for HTML display
	    $query = str_replace("'", '', $query);
	    $query = str_replace('"', '', $query);
	    $query_array = preg_split('/[\s,\+\.]+/',$query);
	    $query_terms = implode(' ', $query_array);
	    $terms = htmlspecialchars(urldecode(trim($query_terms)));

	    return $terms;
	}
}