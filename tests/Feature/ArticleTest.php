<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     *
     * @test
     */
    public function exists_get_articles_route()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/get-articles');
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function it_should_get_articles()
    {
        $this->withoutExceptionHandling();

        $this->getJson(route('articles.get', ['page' => 1]))
                ->assertOk()
                ->assertJsonStructure(
                    [
                        'data' => [
                            [
                                'id',
                                'name',
                                'description',
                                'status',
                                'categories' => [
                                    [
                                        'id',
                                        'name',
                                    ]
                                ],

                                'link',
                            ]
                        ],
                        'count',
                        'pagination_more',
                        'per_page',
                        'total_pages',
                    ]
                );
    }

    /**
     *
     * @test
     */
    public function it_should_search_article()
    {
        $this->withoutExceptionHandling();

        $article = Article::factory()->has(
            Category::factory()
                ->count(1)
        )->create()->toArray();

        $this->getJson(route('articles.get', ['page' => 1, 'search' => $article['name']]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        [
                            'id',
                            'name',
                            'description',
                            'status',
                            'categories' => [
                                [
                                    'id',
                                    'name',
                                ]
                            ],
                            'link',
                        ]
                    ],
                    'count',
                    'pagination_more',
                    'per_page',
                    'total_pages',
                ]
            );
    }

    /**
     *
     * @test
     */
    public function it_cant_search_article_articles_without_page_param()
    {
        $this->withoutExceptionHandling();

        $this->getJson(route('articles.get'))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        [
                            'id',
                            'name',
                            'description',
                            'status',
                            'categories' => [
                                [
                                    'id',
                                    'name',
                                ]
                            ],
                            'link',
                        ]
                    ],
                    'count',
                    'pagination_more',
                    'per_page',
                    'total_pages',
                ]
            );
    }

    public function it_should_search_article_without_category()
    {
        $this->withoutExceptionHandling();

        $article = Article::factory()->create()->toArray();

        $this->getJson(route('articles.get', ['page' => 1, 'search' => $article['name']]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        [
                            'id',
                            'name',
                            'description',
                            'status',
                            'categories' => [
                                [
                                    'id',
                                    'name',
                                ]
                            ],
                            'link',
                        ]
                    ],
                    'count',
                    'pagination_more',
                    'per_page',
                    'total_pages',
                ]
            );
    }

    /**
     *
     * @test
     */
    public function it_should_get_a_one_article()
    {
        $this->withoutExceptionHandling();
        $article = Article::factory()->create()->toArray();

        $this->getJson(route('article.get', ['id' => $article['id']]))
            ->assertOk()
            ->assertJsonStructure(
                        [
                            'id',
                            'name',
                            'description',
                            'status',
                            'categories' => [
                                [
                                    'id',
                                    'name',
                                ]
                            ],
                            'link',
                        ]
            );
    }
}
