<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurrogatePeople;
use App\Models\SurrogatePeopleTranslation;
use App\Models\SurrogatePeopleImage;
use App\Models\Slug;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SurrogatePeopleSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data
        SurrogatePeopleImage::truncate();
        SurrogatePeopleTranslation::truncate();
        SurrogatePeople::truncate();
        Slug::where('slugable_type', SurrogatePeople::class)->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Faker::create();
        $locales = ['ka', 'en']; // Using proper locale codes

        for ($i = 0; $i < 10; $i++) {
            $surrogate = SurrogatePeople::create([
                'age' => $faker->numberBetween(21, 35),
                'height' => $faker->numberBetween(155, 180),
                'weight' => $faker->numberBetween(45, 75),
                'blood_type' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'code' => 'SP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT)
            ]);

            // Add image
            SurrogatePeopleImage::create([
                'surrogate_people_id' => $surrogate->id,
                'image_path' => 'assets/images/img/teamimg.jpg',
                'order' => 0
            ]);

            foreach ($locales as $locale) {
                $title = $faker->name;
                $slug = Str::slug($title) . '-' . Str::random(6); // Create unique slug

                SurrogatePeopleTranslation::create([
                    'surrogate_people_id' => $surrogate->id,
                    'locale' => $locale,
                    'slug' => $slug,
                    'title' => $title,
                    'name' => $faker->firstName,
                    'surname' => $faker->lastName,
                    'nationality' => $faker->country,
                    'hair_color' => $faker->randomElement(['Black', 'Brown', 'Blonde', 'Red', 'Auburn']),
                    'eye_color' => $faker->randomElement(['Brown', 'Blue', 'Green', 'Hazel']),
                    'skin_complexion' => $faker->randomElement(['Fair', 'Medium', 'Olive', 'Tan', 'Dark']),
                    'education' => $faker->randomElement(['High School', 'Bachelor\'s Degree', 'Master\'s Degree', 'PhD']),
                    'marital_status' => $faker->randomElement(['Single', 'Married', 'Divorced']),
                    'race' => $faker->randomElement(['Caucasian', 'Asian', 'African', 'Hispanic', 'Mixed']),
                    'donation_experience' => $faker->randomElement(['First time', '1-2 times', '3-5 times', 'More than 5 times']),
                ]);

                // Create full slug in slugs table
                Slug::create([
                    'fullSlug' => $locale.'/'.$slug,
                    'locale' => $locale,
                    'slugable_id' => $surrogate->id,
                    'slugable_type' => get_class($surrogate)
                ]);
            }
        }
    }
}
