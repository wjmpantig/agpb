<?php
namespace App\Factories\Search;
use Faker\Factory;
use Log;
use Carbon\Carbon;
class SearchTwitter implements SearchInterface{

	private $keys = [];
	private $faker;
	public static $NAME = 'twitter';
	private static $URL = "https://api.twitter.com/1.1/search/tweets.json";
	private static $REQUEST_METHOD = "GET";
	public static $QUERY_FILTERS = "filter:safe filter:media";
	private static $MAX_RESULTS = 100;
	private $twitter;
	function __construct($keys){
		$this->keys = $keys;
		$this->twitter = new \TwitterAPIExchange($this->keys);
		$this->faker = Factory::create();
	}
	public function do($name){
		$faker = $this->faker;
		
		
		$twitter = $this->twitter;
		$data = array(
			'q'=>$name. " ".self::$QUERY_FILTERS,
			// 'q'=>$name,
			'count'=>self::$MAX_RESULTS,
			'include_entities'=>true
		);
		
		
		$data['result_type']= $this->faker->randomElement(['mixed','popular','recent']);
		if($faker->boolean){
			$date = Carbon::now();
			$date->subDays(1,7);
			// $date->subDays(7);
			$data['until']=$date->format("Y-m-d");
		}

		$getField = http_build_query($data,'','&',PHP_QUERY_RFC1738);
		$getField = urldecode($getField);
		// Log::debug("searching ". self::$NAME . ' with params: ', $data);
		Log::debug("searching ". self::$NAME . ' with params: ', $data);
		// Log::debug("searching ". $getField);
		$results = json_decode($twitter->setGetfield("?".$getField)
			->buildOauth(self::$URL,self::$REQUEST_METHOD)
			->performRequest());
		
		// return $results;
		$result = $this->process_result($results);
		if(is_null($result)){
			return null;
		}
		$result['query']=$getField;
		return $result;
	
	}

	private function process_result($results){
		$faker = $this->faker;
		$resultCount = count($results->statuses);
		if($resultCount == 0){
			return null;
		}
		do{

			$resultIndex = $faker->numberBetween(0,$resultCount-1);
			$result = $results->statuses[$resultIndex]; //pick random status
			if(!isset($result->entities->media)){
				if($resultCount == 1){
					return null; //no media in results, return null
				}
				continue;
			}
			// dd($result);
			$resultMedia = $result->extended_entities->media[$faker->numberBetween(0,count($result->extended_entities->media)-1)];
			$finalResult = [
				'type' => $resultMedia->type,
				'url'=>$resultMedia->url,
				'description'=>mb_strimwidth($result->text,0,200,'...'),
				'filename'=>$resultMedia->media_url,
				'source'=>self::$NAME
			];
			
			if($resultMedia->type=='video'){
				$video = collect($resultMedia->video_info->variants)->filter(function($val,$key){
					return $val->content_type="video/mp4";
				})->sortByDesc('bitrate')->first();
				$finalResult['video'] = $video->url;
			}
			// Log::debug(json_encode($resultMedia));
			return $finalResult;
			// return response()->json($result);
			// break;
		}while(true);
	}


}