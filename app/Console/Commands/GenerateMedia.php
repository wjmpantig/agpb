<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\Search\SearchFactory;
use App\Media;
use App\Profile;
use Faker\Factory;

class GenerateMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:generate {--profile=} {--source=} {--count=1}';

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
        $count = $opts['count'];
        
        if(empty($profile)){
            $profile = Profile::with('altNames')->inRandomOrder()->first();
        }else{
            $profile = Profile::with('altNames')->where('id',$profile)->orWhere('slug',$profile)->first();
        }
        if(!$profile){
            $this->error('No profiles found');
            return 0;
        }
        
        if(!empty($source) && !$this->searchFactory->hasImplemented($source)){
            $this->error('Source not found');
            return 0;
        }
        $source = empty($source) ? null : $source;

        if(!is_numeric($count)){
            $this->error('count option must be a positive integer');
            return 0;
        }
        $count = intval($count);
        if($count < 1){
            $this->error('count option must be a positive integer');
            return 0;
        }
        $this->info("Profile: " . $profile->name);
        $q = $profile->name;
        if($profile->altNames->count() > 0 && $faker->boolean){
            $altname = $profile->altNames->random();
            $q = $altname->name;
        }
        $bar = $this->output->createProgressBar($count);
        $ids = [];
        $tries = 0;
        for($i=0;$i<$count;$i++){
            // $this->info($i);
            if($tries==3){
                $this->info('maximum tries reached');
                break;
            }
            $result = $this->searchFactory->do($q,$source);
            if(!$result){
                $this->info('no result, repeat search');
                $i--;
                $tries++;
                continue;
            }
            $exists = Media::where('filename',$result['filename'])->first();
            if($exists){
                $this->info('image already exists, repeat search');
                $i--;
                $tries++;
                continue;
            }

            // dd($result);
            $media = new Media($result);
            $media->profile_id = $profile->id;
            $media->save();
            $ids[] = $media->id;
            $bar->advance();
        }
        $bar->finish();
        return $ids;

    }
}
