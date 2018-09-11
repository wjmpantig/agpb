<?php
namespace App\Factories\Search;
use Faker\Factory;
use Log;
interface SearchInterface{
	public function do($name);
}
class SearchFactory{
	private $implementations = [];
	private $faker;
	function __construct(){
		$this->faker = Factory::create();
	}
	public function register(SearchInterface $instance){
		$this->implementations[] = $instance;
		return $this;
	}
	public function do($name,$index = null){
		// Log::debug($this->implementations);
		if(empty($this->implementations)){
			throw new \Exception('No implementations for search');
		}
		// Log::debug("index search $index");
		$i = $this->implementations;
		$index = is_null($index) ? $this->faker->numberBetween(0,count($i)-1) : $index;
		// Log::debug("index search $index");

		return $i[$index]->do($name);
	}
	
}