<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\SubCategory;
use App\Services\ArticleService;
use App\Services\StoreArticleService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NewsApiArticleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $storeArticleService;
    public function __construct(StoreArticleService $storeArticleService)
    {
        $this->storeArticleService = $storeArticleService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->storeArticleService->newsApi();
    }

}
