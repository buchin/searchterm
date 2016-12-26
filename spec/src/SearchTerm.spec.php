<?php
use Buchin\SearchTerm\SearchTerm;

describe('SearchTerm', function(){

	describe('get()', function(){
		context('when referer is empty', function(){
			it('return false', function(){
				$result = SearchTerm::get('');

				expect($result)->toBeFalsy();
			});
		});

		context('when coming from non search engine', function(){
			it('return false', function(){
				$result = SearchTerm::get('http://www.zipzipan.com');

				expect($result)->toBeFalsy();
			});
		});

		context('when coming from search engine', function(){
			it('return search term', function(){
				$result = SearchTerm::get('https://www.google.co.id/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=makan%20nasi');
				expect($result)->toBe('makan nasi');

				$result = SearchTerm::get('https://www.bing.com/search?q=ketela+mambu&hl=en');
				expect($result)->toBe('ketela mambu');
			});
		});
	});
});