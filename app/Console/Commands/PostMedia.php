<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\Post\PostFactory;
use App\Media;
use App\Post;
use Log;
use Artisan;
class PostMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:post {--id=} {--dest=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $postFactory;
    private $searchFactory;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PostFactory $postFactory)
    {
        parent::__construct();
        $this->postFactory = $postFactory;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $opts = $this->options();
        $id = $opts['id'];
        $dest = $opts['dest'];
        $media = null;
        
        
        if(empty($id)){
            
            do{
                Artisan::call('media:generate');
                $id = str_replace('\r\n', '', Artisan::output());
                $media = Media::with('profile.altNames')
                    ->where('id',$id)
                    ->where('type','video')
                    ->first();
            }while(empty($id) || is_null($media));
        }
        $media = Media::with('profile.altNames')
            ->where('type','photo')
            ->where('id',$id)
            ->first();
        if(!$media){
            return;
        }
        Log::info("uploading media $media->id ...");
        $post = $this->postFactory->make($media,$dest);


    }
}
