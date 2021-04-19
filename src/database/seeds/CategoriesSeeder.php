<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
        	'title'	=>	'Electronic';
        ]);

        Category::create([
        	'title'	=>	'Computer',
        	'parent_id'	=>	1
        ]);

        Category::create([
        	'title'	=>	'Mobile',
        	'parent_id'	=>	1
        ]);

        Category::create([
        	'title'	=>	'Laptop',
        	'parent_id'	=>	1
        ]);

        Category::create([
        	'title'	=>	'Animals',
        ]);

        Category::create([
        	'title'	=>	'Cat',
        	'parent_id'	=>	4
        ]);

        Category::create([
        	'title'	=>	'Dog',
        	'parent_id'	=>	5
        ]);

        Category::create([
        	'title'	=>	'Males',
        ]);

        Category::create([
        	'title'	=>	'Ahmed',
        	'parent_id'	=>	8
        ]);

        Category::create([
        	'title'	=>	'Mohamed',
        	'parent_id'	=>	8
        ]);

        Category::create([
        	'title'	=>	'Hassan',
        	'parent_id'	=>	8
        ]);

        Category::create([
        	'title'	=>	'Alaa',
        	'parent_id'	=>	8
        ]);

        Category::create([
        	'title'	=>	'Females',
        	'parent_id'	=>	8
        ]);

        Category::create([
        	'title'	=>	'Heba',
        	'parent_id'	=>	13
        ]);

        Category::create([
        	'title'	=>	'Sara',
        	'parent_id'	=>	13
        ]);

        Category::create([
        	'title'	=>	'Marwa',
        	'parent_id'	=>	13
        ]);
    }
}
