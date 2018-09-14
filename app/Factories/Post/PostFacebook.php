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
		
		$token = $this->fb->post("/$page_id/feed?message=testmessage");
		return $token;

	}
}