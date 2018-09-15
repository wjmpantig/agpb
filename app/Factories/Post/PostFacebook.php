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
	private $header;

	function __construct(){
		
		$this->page_id = env('FACEBOOK_PAGE_ID',null);
		$this->access_token = env('FACEBOOK_PAGE_ACCESS_TOKEN',null);
		$this->client = new Client([
			'base_uri'=>self::$BASE_URL,
			'timeout'=>self::$TIMEOUT
		]);
		$this->header = [
			'Authorization'=>'Bearer ' . $this->access_token,
			'Content-type'=>'application/json',
			'Accept'=>'application/json'
		];
	}

	public function make($media,$caption){
		$page_id = $this->page_id;
		
		
		$params = [
			'url'=>$media->filename,
			'published'=>true,
			'access_token'=>$this->access_token,
			'caption'=> $caption
		];
		
		$response = $this->client->post("/$page_id/photos",[
				'header'=>$this->header,
				'form_params'=>$params
			]);
		$result = json_decode($response->getBody(),true);
		// Log::debug($response->getStatusCode());
		// Log::debug($response->getBody());
		$post_id = $result['post_id'];
		$url = "https://www.facebook.com/".$post_id;
		Log::debug('posted in facebook: ' . $url);
		$final_result = [
			'type' => self::$NAME,
			'url'=>$url,
			'post_id'=>$post_id
		];
		


		return $final_result;

	}

	public function reply($post,$reply){
				
		$params = [
			'message'=>$reply,
			'access_token'=>$this->access_token
		];
		
		$response = $this->client->post("/$post_id/comments",[
			'header'=>$this->header,
			'form_params'=>$params
		]);
	}

}