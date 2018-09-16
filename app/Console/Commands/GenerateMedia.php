<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\Search\SearchFactory;
use App\Media;
use App\Profile;
use Faker\Factory;
use Log;
class GenerateMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:generate {--profile=} {--source=}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $searchFactory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SearchFactory $factory)
    {
        parent::__construct();
        $this->searchFactory = $factory;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $faker = Factory::create();
        $opts = $this->options();
        $profile = $opts['profile'];
        $source = $opts['source'];
        
        
        if(empty($profile)){
            $profile = Profile::with('altNames')->inRandomOrder()->first();
        }else{
            $profile = Profile::with('altNames')->where('id',$profile)->orWhere('slug',$profile)->first();
        }
        if(!$profile){
            Log::error('No profiles found');
            return 0;
        }
        
        if(!empty($source) && !$this->searchFactory->hasImplemented($source)){
            Log::error('Source not found');
            return 0;
        }
        $source = empty($source) ? null : $source;

      
        // Log::info("Profile: " . $profile->name);
        $q = $profile->name;
        if($profile->altNames->count() > 0 && $faker->boolean){
            $altname = $profile->altNames->random();
            $q = $altname->name;
        }
        
        $ids = [];
                    
        $result = $this->searchFactory->do($q,$source);
        if(!$result){
            Log::info('no results found..');
            return;
        }
        $exists = Media::where('filename',$result['filename'])->first();
    
        
        $media = new Media($result);
        $media->profile_id = $profile->id;
        $media->save();
        $ids[] = $media->id;
        
        $this->info(implode(',',$ids));

    }
}
