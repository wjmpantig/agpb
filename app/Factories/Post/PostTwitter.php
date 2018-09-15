<?php
namespace App\Factories\Post;
use Log;
class PostTwitter implements PostInterface{
	private $keys = [];
	public static $NAME = 'twitter';
	private static $UPLOAD_URL = "https://upload.twitter.com/1.1/media/upload.json";
	private static $UPDATE_URL = "https://api.twitter.com/1.1/statuses/update.json";
	private static $REQUEST_METHOD = "POST";
	
	function __construct($keys){
		$this->keys = $keys;
		$this->twitter = new \TwitterAPIExchange($this->keys);
	}

	public function make($media,$caption){
		$twitter = $this->twitter;
		$data = file_get_contents($media->filename);
        $base64 = base64_encode($data);
		$postField =[
			'media_data'=>$base64
		];

		$result = $twitter->setPostfields($postField)
		    ->buildOauth(self::$UPLOAD_URL, self::$REQUEST_METHOD)
		    ->performRequest(true,[CURLOPT_TIMEOUT=>20]);
		$upload = json_decode($result,true);
		if(isset($upload['error'])){
			Log::error('unable to upload media',$upload);
			return null;
		}
		Log::debug("uploaded media",$upload);
		$query = $media->query;
		parse_str($query,$query);
		$postField = [
			'status'=>$query['q'],
			'media_ids'=>$upload['media_id_string']
		];
		$result = $twitter->setPostfields($postField)
		    ->buildOauth(self::$UPDATE_URL, self::$REQUEST_METHOD)
		    ->performRequest();
		$result = json_decode($result,true);
		$url = $result['entities']['media'][0]['url'];
        Log::debug('tweet posted: '.$url);

	    if(isset($result['error'])){
			Log::error('unable to post tweet',$result);
			return null;
		}
		$final_result = [
			'type' => self::$NAME,
			'url'=>$url,
			'post_id'=>$result['id_str']
		];
		return $final_result;
	}

	public function reply($post,$reply){

	}
}