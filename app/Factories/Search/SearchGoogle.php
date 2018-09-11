<?php
namespace App\Factories\Search;

use Faker\Factory;
use Log;
class SearchGoogle implements SearchInterface{
	private $settings = [];
	private $faker;
	private static $URL = "https://www.googleapis.com/customsearch/v1";
	private static $MAX_RESULTS = 100;
	private static $NAME = 'google';
	function __construct($settings){
		$this->settings = $settings;
		$this->faker = Factory::create();
	}

	public function do($name){
		$options = [
				'imgSize' => 'large',
				'q'=>$name,
				'searchType'=>'image',
				'safe'=>'active'
			];
		//try search first and check total results
		$results = $this->search($options);
		$totalResults = $results->searchInformation->totalResults;

		if($totalResults ==0){
			return null;
		}else if ($totalResults > self::$MAX_RESULTS){
			$max = self::$MAX_RESULTS;
		}

		$index = $this->faker->numberBetween(1,$max);
		//search single result on specific index
		$options['num'] = 1;
		$options['start'] = $index;
		$result = $this->search($options)->items[0];
		// return dd($result);
		$finalResult = [
			'title'=>mb_strimwidth($result->title,0,100,'...'),
			'description'=>mb_strimwidth($result->snippet,0,200,"..."),
			'filename'=>$result->link,
			'type'=>'photo',
			'url'=>$result->image->contextLink,
			'source'=>self::$NAME
		];
		return $finalResult;
	}

	private function search($params){
		$query = http_build_query(array_merge($params,$this->settings),'','&');
		Log::debug("searching ". self::$NAME . ' with params: ', $params);
		$url = self::$URL.'?'.$query;
		$file = file($url);
		$results = json_decode(implode('',$file));
		return $results;
	}
}