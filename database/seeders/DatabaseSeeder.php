<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory(5)->create()->each(function (User $user) {
            $user->questions()
                ->saveMany(Question::factory(rand(2, 5))->make())
                ->each(function (Question $question) {
                    $question->answers()->saveMany(Answer::factory(rand(2, 7))->make());
                });
        });
    }
}
