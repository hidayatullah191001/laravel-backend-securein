<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Label;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        Category::create([
            'title' => 'All'
        ]);
        
        Category::create([
            'title' => 'Social Media'
        ]);

        Category::create([
            'title' => 'Finance'
        ]);

        Category::create([
            'title' => 'Email'
        ]);

        Category::create([
            'title' => 'Shopping'
        ]);

        Category::create([
            'title' => 'Entertainment'
        ]);

        Category::create([
            'title' => 'Health'
        ]);

        Category::create([
            'title' => 'Work'
        ]);

        Category::create([
            'title' => 'Education'
        ]);

        Category::create([
            'title' => 'Travel'
        ]);

        Category::create([
            'title' => 'Gaming'
        ]);

        Category::create([
            'title' => 'Investment'
        ]);

        Label::create([
            'category_id' => 12,
            'label' => 'Bibit',
            'label_logo' => 'bibit.png'
        ]);

        Label::create([
            'category_id' => 12,
            'label' => 'Indodax',
            'label_logo' => 'bibit.png'
        ]);

        Label::create([
            'category_id' => 4,
            'label' => 'Gmail',
            'label_logo' => 'gmail.png'
        ]);

        Label::create([
            'category_id' => 2,
            'label' => 'Instagram',
            'label_logo' => 'instagram.png'
        ]);

        Label::create([
            'category_id' => 3,
            'label' => 'Mandiri',
            'label_logo' => 'mandiri.png'
        ]);

        Label::create([
            'category_id' => 3,
            'label' => 'BNI',
            'label_logo' => 'bni.png'
        ]);
        
        Label::create([
            'category_id' => 3,
            'label' => 'BCA',
            'label_logo' => 'bca.png'
        ]);

        Label::create([
            'category_id' => 3,
            'label' => 'BTN',
            'label_logo' => 'btn.png'
        ]);

        Label::create([
            'category_id' => 3,
            'label' => 'OCBC',
            'label_logo' => 'ocbc.png'
        ]);
    }
}
