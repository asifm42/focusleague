<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Post::class)->create([
            'type' => 'news',
            'title' => 'FOCUS League Officially Announced',
            'content' => 'I am proud and excited to officially announce the FOCUS League. User accounts and Cycle 1 Sign ups are scheduled to open on March 9th, 2016. Make sure to check the FAQ page for more details.',
            'posted_by' => 1,
            'created_at' => '2016-03-05 09:00:00',
            'updated_at'=> '2016-03-05 09:00:00',
        ]);

        //factory(App\Models\Post::class, 3)->create();
    }
}
