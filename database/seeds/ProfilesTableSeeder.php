<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Profile;
use App\AltName;
class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$path = storage_path('app/imports/profiles.csv');
        $csv = Reader::createFromPath($path,'r');
		$csv->setHeaderOffset(0);
		$stmt = new Statement();

		$records = $stmt->process($csv);
		foreach($records as $offset => $record){
			$profile = new Profile();
			$profile->name = $record['name'];
			$profile->slug = str_slug($record['name']);
			$profile->save();
			foreach($record as $desc=>$val){
				if($desc=='name' || empty($val)){
					continue;
				}
				$altname = new AltName();
				$altname->profile_id = $profile->id;
				$altname->name = $val;
				$altname->description = $desc;
				$altname->save();
			}


		}
    }
}
