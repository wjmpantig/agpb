<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Factories\Post\PostFactory;
use App\Media;
use App\Post;
use Log;
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
        $result = $this->postFactory->do($media,$dest);
        $this->info($result);
        return;
        if(empty($id)){
            $media = $this->call('media:generate');
            $this->info($media);
            $media = Media::whereIn('id',$media)->inRandomOrder()->first();
        }else{
            $media = Media::where('type','photo')->where('id',$id)->firstOrFail();
        }
        $this->info("uploading media $media->id ...");
        $result = $this->postFactory->do($media);
        if(is_null($result)){
            $this->error('posting failed');
        }
        $post = new Post();
        $post->type = $result['post_type'];
        if($post->type == 'twitter'){
            $url= $result['entities']['media'][0]['url'];
            Log::debug('tweet posted: '.$url);
            $post->url = $url;
        }

        $post->save();
        $this->info('post successful: ' . $post->id);
    }
}
