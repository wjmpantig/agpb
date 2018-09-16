<?php
namespace App\Factories\Post;
use Faker\Factory;
use Log;
use App\Post;

interface PostInterface{
	public function make($media,$caption);
	public function reply($post,$reply);
}
class PostFactory{
	private $implementations;
	private $faker;
	function __construct(){
		$this->implementations = collect([]);
		$this->faker = Factory::create();
	}
	public function register(PostInterface $instance){
		$this->implementations->put($instance::$NAME,$instance);
		return $this;
	}

	public function names(){
		return $this->implementations->keys();
	}

	public function hasImplemented($name){
		return $this->implementations->has($name);
	}


	public function make($media,$dest = null){
		if(empty($this->implementations)){
			throw new \Exception('No implementations for post');
		}
		// Log::debug("index search $index");
		$i = $this->implementations;
		$caption = $this->build_caption($media);

		if(is_null($dest)){
			$i = $this->implementations->random();
		}else if(!$this->hasImplemented($dest)){
			throw new \Exception("Invalid destination name");
		}else{
			$i = $this->implementations->get($dest);
		}
        $result = $i->make($media,$caption);
		if(is_null($result)){
            Log::error('posting failed');
            return 1;
        }
        $post = new Post($result);
        $post->media_id = $media->id;
        $post->save();
        Log::info('post successful: ' . $post->id);
        if(!is_null($post->post_id)){
			$reply = $this->build_reply($media);
	        $i->reply($post,$reply);
	        	
        }
		return $post;
	}

	 private function build_caption($media){
		$query = $media->query;
		parse_str($query,$query);
		$caption = $query['q'];
		if($media->type=='twitter'){

		}
		return $caption;
	}

	private function build_reply($media){
		$reply = "Source: $media->url 
			Search type: $media->source";
		return $reply;
	}
}
