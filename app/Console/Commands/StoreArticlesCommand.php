<?php

namespace App\Console\Commands;

use App\Jobs\GuardianArticleJob;
use App\Jobs\NewsApiArticleJob;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\ArticleService;
use App\Services\StoreArticleService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class StoreArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


     protected $storeArticleService;

     public function __construct(StoreArticleService $storeArticleService)
     {
         parent::__construct();
         $this->storeArticleService = $storeArticleService;
     }
    public function handle()
    {
        dispatch(new NewsApiArticleJob($this->storeArticleService));
        dispatch(new GuardianArticleJob($this->storeArticleService));

    }

}
