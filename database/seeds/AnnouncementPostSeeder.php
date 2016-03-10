<?php

use Illuminate\Database\Seeder;

class AnnouncementPostSeeder extends Seeder
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
            'content' => "I am proud and excited to officially announce the FOCUS League. Sign up for Cyle 2016-01 is now open. You will need a player account to sign up. Don't have one? You can <a href='/signup'>get one here</a>. First game will be on Tuesday, March 15th, 2016 at 8p. Make sure to check the <a href='/faq'>FAQ</a> page for more details. Hope to see you out at HSP on a Tuesday!",
            'posted_by' => 1,
            'created_at' => '2016-03-09 09:00:00',
            'updated_at'=> '2016-03-09 09:00:00',
        ]);
    }
}
