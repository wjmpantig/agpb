<?php

namespace App\Factories\Search;
use Faker\Factory;
use Log;
use Carbon\Carbon;
use Youtube;
class SearchYoutube implements SearchInterface{
	public static $NAME = 'youtube';
	public static $ORDER_TYPES = ['relevance','date','rating','title','videoCount','viewCount'];
	private static $MAX_RESULTS = 50;
	private static $BASE_URL = 'https://www.youtube.com/watch?v=';
	private $faker;
	function __construct(){
		$this->faker = Factory::create();
	}
	public function do($name){
		$params = [
			'q'=>$name,
			'type'=>'video',
			'order'=>$this->faker->randomElement(self::$ORDER_TYPES),
			'maxResults'=>self::$MAX_RESULTS,
			'part'=>'id,snippet'
		];
		$results = Youtube::searchAdvanced($params);
		// Log::debug($results);
		$result = $this->process_result($results);
		$result['query']=http_build_query($params);
		return $result;
	}
	private function process_result($results){
		$faker = $this->faker;
		$resultCount = count($results);
		if($resultCount == 0){
			return null;
		}
		do{
			$index = $faker->numberBetween(0,$resultCount-1);
			$result = $results[$index];

			
			$url = self::$BASE_URL . $result->id->videoId;
			$title= $result->snippet->title;
			$description=mb_strimwidth($result->snippet->description,0,200,'...');
			$thumbnails = $result->snippet->thumbnails;
			$filename = isset($thumbnails->high) ? $thumbnails->high->url : $thumbnails->default->url;
			$final_result = [
				'type'=>'video',
				'url'=>$url,
				'title'=>$title,
				'filename'=>$filename,
				'source'=>self::$NAME,
				'description'=>$description
			];
			return $final_result;
		}while(true);
		
	}

}