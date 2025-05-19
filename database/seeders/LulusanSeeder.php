<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Regency;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $regencies = Regency::pluck('id')->toArray();
        $topics = Topic::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $upvote = $faker->numberBetween(0, 1000);
            $downvote = $faker->numberBetween(0, 500);

            $post = Post::create([
                'caption' => $faker->sentence,
                'img_path' => $faker->imageUrl(640, 480, 'nature'),
                'video_path' => null,
                'upvote' => $upvote,
                'downvote' => $downvote,
                'clean_vote' => 0, 
                'comment_count' => 0, 
                'location' => $faker->randomElement($regencies),
                'time_happening' => $faker->optional()->dateTimeBetween('-1 year', 'now'),
                'geo_location' => $faker->latitude() . ',' . $faker->longitude(),
                'topic_id' => $faker->randomElement($topics),
            ]);

            // Hitung clean_vote
            $post->clean_vote = $upvote - $downvote;

            // Hitung comment_count dari tabel comments
            $countComments = Comment::where('post_id', $post->id)->count();

            $post->comment_count = $countComments;

            $post->save();
        }
    }
}
