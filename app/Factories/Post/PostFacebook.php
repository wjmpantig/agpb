<?php
namespace App\Factories\Post;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Log;
use App;
class PostFacebook implements PostInterface{
	public static $NAME = 'facebook';
	private $fb;
	private $page_id;
	private $access_token;
	function __construct(){
		$this->fb = App::make(LaravelFacebookSdk::class);
		$this->page_id = env('FACEBOOK_PAGE_ID',null);
		$this->access_token = env('FACEBOOK_PAGE_ACCESS_TOKEN',null);
		$this->fb->setDefaultAccessToken($this->access_token);
	}

	public function do($media){
		$page_id = $this->page_id;
		$graph_ver = "v3.1";
		// return $this->access_token;
		// $file = $this->fetchFile($media->filename);
		// Log::debug('download file: ' . $media->filename . ' to ' . $file);
		
		$query = $media->query;
		parse_str($query,$query);
		$params = [
			'url'=>$media->filename,
			'published'=>true
		];
		$response = $this->fb->post("/$page_id/photos?",$params,$this->access_token,null,$graph_ver);
		$object =  $response->getGraphObject()->asArray();
		$url = "https://www.facebook.com/".$object['post_id'];
		Log::debug('posted in facebook: ' . $url);
		$final_result = [
			'type' => self::$NAME,
			'url'=>$url
		];

		return $final_result;

	}

	private function fetchFile($url){
    	$info = pathinfo($url);
		$contents = file_get_contents($url);
		$file = tempnam(sys_get_temp_dir(), 'agpb_');
		file_put_contents($file, $contents);
		return $file;
    }
}