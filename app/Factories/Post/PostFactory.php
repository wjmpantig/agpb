<?php
namespace App\Factories\Post;
use Faker\Factory;
use Log;
interface PostInterface{
	public function do($media);
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


	public function do($media,$dest = null){
		if(empty($this->implementations)){
			throw new \Exception('No implementations for post');
		}
		// Log::debug("index search $index");
		$i = $this->implementations;
		if(is_null($dest)){
			return $i->random()->do($media);
		}
		if(!$this->hasImplemented($dest)){
			throw new \Exception("Invalid destination name");
		}
		return $i->get($dest)->do($media);
	}
}
