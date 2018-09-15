<?php
namespace App\Factories\Post;
use GuzzleHttp\Client;

use Log;
use App;
class PostFacebook implements PostInterface{
	public static $NAME = 'facebook';
	
	private $page_id;
	private $access_token;
	private static $BASE_URL = "https://graph.facebook.com";
	private static $TIMEOUT = 20.0;
	private $client;

	function __construct(){
		
		$this->page_id = env('FACEBOOK_PAGE_ID',null);
		$this->access_token = env('FACEBOOK_PAGE_ACCESS_TOKEN',null);
		$this->client = new Client([
			'base_uri'=>self::$BASE_URL,
			'timeout'=>self::$TIMEOUT
		]);
	}

	public function do($media){
		$page_id = $this->page_id;
		
		
		
		$query = $media->query;
		parse_str($query,$query);
		$params = [
			'url'=>$media->filename,
			'published'=>true,
			'access_token'=>$this->access_token
		];
		$header = [
			'Authorization'=>'Bearer ' . $this->access_token,
			'Content-type'=>'application/json',
			'Accept'=>'applicaiton/json'
		];
		$response = $this->client->post("/$page_id/photos",[
				'header'=>$header,
				'form_params'=>$params
			]);
		$result = json_decode($response->getBody(),true);
		// Log::debug($response->getStatusCode());
		// Log::debug($response->getBody());
		
		$url = "https://www.facebook.com/".$result['post_id'];
		Log::debug('posted in facebook: ' . $url);
		$final_result = [
			'type' => self::$NAME,
			'url'=>$url
		];

		return $final_result;

	}

}