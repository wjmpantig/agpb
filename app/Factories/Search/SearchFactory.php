<?php
namespace App\Factories\Search;
use Faker\Factory;
use Log;
interface SearchInterface{
	public function do($name);
}
class SearchFactory{
	private $implementations;
	private $faker;
	function __construct(){
		$this->implementations = collect([]);
		$this->faker = Factory::create();
	}
	public function register(SearchInterface $instance){
		$this->implementations->put($instance::$NAME,$instance);
		return $this;
	}

	public function names(){
		return $this->implementations->keys();
	}

	public function hasImplemented($name){
		return $this->implementations->has($name);
	}


	public function do($name,$source = null){
		// Log::debug($this->implementations);
		if(empty($this->implementations)){
			throw new \Exception('No implementations for search');
		}
		// Log::debug("index search $index");
		$i = $this->implementations;
		if(is_null($source) || empty($source)){
			return $i->random()->do($name);
		}
		if(!$this->hasImplemented($source)){
			throw new \Exception("Invalid source name");
		}
		return $i->get($source)->do($name);
		
	}
	
}