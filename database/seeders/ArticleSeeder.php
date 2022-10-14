<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    private \Faker\Generator $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Factory::create();

        Article::factory()
            ->has(
                Category::factory()
                    ->count($this->faker->numberBetween(1, 2))
            )
            ->count(10)
            ->create();
    }
}
