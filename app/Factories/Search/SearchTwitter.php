<?php
namespace App\Factories\Search;
use Faker\Factory;
use Log;
class SearchTwitter implements SearchInterface{

	private $keys = [];
	private $faker;
	function __construct($keys){
		$this->keys = $keys;
		$this->faker = Factory::create();
	}
	public function do($name){
		$faker = $this->faker;
		$url = "https://api.twitter.com/1.1/search/tweets.json";
		$requestMethod = 'GET';
		$twitter = new \TwitterAPIExchange($this->keys);
		$data = array(
			'q'=>$name,
			'count'=>100
		);
		$getField = http_build_query($data);
		$results = collect(json_decode($twitter->setGetfield($getField)
			->buildOauth($url,$requestMethod)
			->performRequest()));
		$resultCount = count($results['statuses']);
		$finalResult = new \stdClass();
		do{

			$resultIndex = $faker->numberBetween(0,$resultCount-1);
			$result = $results['statuses'][$resultIndex];
			if(!isset($result->entities->media)){
				if($resultCount == 1){
					break;
				}
				continue;
			}

			$resultMedia = $result->extended_entities->media[$faker->numberBetween(0,count($result->extended_entities->media)-1)];
			$finalResult->type = $resultMedia->type;
			$finalResult->description = $result->text;
			$finalResult->media_url = $resultMedia->media_url;
			$finalResult->url = $resultMedia->url;			
			if($resultMedia->type=='video'){
				$video = collect($resultMedia->video_info->variants)->filter(function($val,$key){
					return $val->content_type="video/mp4";
				})->sortByDesc('bitrate')->first();
				$finalResult->video_url = $video->url;
			}
			// Log::debug(json_encode($resultMedia));
			return $finalResult;
			// return response()->json($result);
			// break;
		}while(true);
		return null;
	}
}