<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReferenceSeeder extends Seeder
{
    /**
     * Example message headers
     *
     * @var array
     */

    protected $themes = ["Помогите мне", "Вы плохие!", "Как я сюда попал?"];

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = Faker::create('ru_RU');
        foreach ($this->themes as $key => $reference) {
            DB::table('references')->insert([
                'name' =>  $faker->lastName($gender = $key % 2 == 0 ? 'male' : 'female') . ' ' . $faker->firstName($gender = $key % 2 == 0 ? 'male' : 'female'),
                'heading' => $reference,
                'message' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'created_at' => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now'),
                'updated_at' => now()
            ]);
        }
    }
}
