<?php

namespace Database\Seeders;

use App\Models\Todolist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todolist::insert([
            [
                "title" => "Learn Laravel Sanctum",
                "description" => "Learning Laravel 11 Sanctum API",
                "is_done" => true,
                "user_id" => 1
            ],
            [
                "title" => "Learn Ruby on Rails 8",
                "description" => "Learning Ruby on Rails 8 API",
                "is_done" => false,
                "user_id" => 1
            ],
        ]);
    }
}
