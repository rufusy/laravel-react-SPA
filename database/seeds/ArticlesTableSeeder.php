<?php

use Illuminate\Database\Seeder;
use App\Article;

class ArticlesTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate all our existing records and start from scratch
        Article::truncate();

        $faker = \Faker\Factory::create();
        
        // Create a few articles in the  database
        for ($i = 0; $i < 50; $i++){
            Article::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'user_id' => 1
            ]);
        }
    }
}
