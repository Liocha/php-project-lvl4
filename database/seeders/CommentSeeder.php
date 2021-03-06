<?php

namespace Database\Seeders;

use App\Models\Task\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()
            ->times(5)
            ->create();
    }
}
