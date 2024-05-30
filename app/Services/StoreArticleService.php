<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Models\SubCategory;
use App\Services\ArticleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreArticleService
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function guardian()
    {
        $date = Carbon::now()->format('Y-m-d');
        $subCategories = SubCategory::get();

        DB::transaction(function () use ($subCategories, $date) {
            foreach ($subCategories as $subCategory) {
                $category = Category::findOrFail($subCategory->category_id);

                $guardianResponse = app(ArticleService::class)->fetchNewsArticles('https://content.guardianapis.com/search', $subCategory->name, $date, '35e4f400-678d-4d12-bf63-b7e75091d583', $category->name . '/' . $category->name);
                if ($guardianResponse->successful()) {
                    $lastDate = DB::table('articles')
                        ->whereNotNull('article_id')
                        ->max('date');

                    $articles = [];
                    foreach ($guardianResponse['response']['results'] as $result) {
                        if (Carbon::parse($result['webPublicationDate'])->format('Y-m-d H:i:s') >= $lastDate) {
                            $articles[] = [
                                'title' => $result['webTitle'],
                                'sub_category_id' => $subCategory->id,
                                'article_id' => $result['id'],
                                'date' => Carbon::parse($result['webPublicationDate'])->format('Y-m-d H:i:s'),
                                'content' => $result['webUrl'],
                                'source_id' => null,
                            ];
                        }
                    }

                    if (!empty($articles)) {
                        Article::insert($articles);
                    }
                }
            }
        });
    }





    public function newsApi()
    {
        $date = Carbon::now()->format('Y-m-d');
        $subCategories = SubCategory::get();

        DB::transaction(function () use ($subCategories, $date) {
            foreach ($subCategories as $subCategory) {
                $category = Category::findOrFail($subCategory->category_id);

                $newsApiResponse = app(ArticleService::class)->fetchNewsArticles('https://newsapi.org/v2/everything', $subCategory->name, $date, 'b4569a220c264d548dc3479cdfb2b95f', null);
                if ($newsApiResponse->successful()) {
                    $articles = $newsApiResponse['articles'];

                    foreach ($articles as $article) {
                        $author = Author::firstOrCreate([
                            'name' => $article['author']
                        ]);

                        $source = Source::firstOrCreate([
                            'name' => $article['source']['name']
                        ]);
                    }
                    $lastDate = DB::table('articles')
                        ->whereNull('article_id')
                        ->max('date');
                    if ($lastDate === null) {
                        $lastDate = new Article();
                        $lastDate->date = Carbon::now()->format('Y-m-d H:i:s');
                    }
                    if (Carbon::parse($article['publishedAt'])->format('Y-m-d H:i:s') >= $lastDate->date) {
                        Article::create([
                            'title' => $article['title'],
                            'sub_category_id' => $subCategory->id,
                            'article_id' => null,
                            'date' => Carbon::parse($article['publishedAt'])->format('Y-m-d H:i:s'),
                            'content' => $article['content'] . PHP_EOL . $article['url'],
                            'source_id' => $source->id,
                            'author_id' => $author->id
                        ]);
                    }
                }
            }
        });
    }

}
