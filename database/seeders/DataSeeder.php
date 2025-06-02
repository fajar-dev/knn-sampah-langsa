<?php

namespace Database\Seeders;

use App\Models\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Data::create(
            [
                'id' => '1',
                'year' => '2020',
                'organic' => 13547.7342,
                'unorganic' => 15979.3788,
            ],
            [
                'id' => '1',
                'year' => '2021',
                'organic' => 13214.4948,
                'unorganic' => 16263.9936,
            ],
            [
                'id' => '1',
                'year' => '2022',
                'organic' => 13443.3936,
                'unorganic' => 17579.8224,
            ],
            [
                'id' => '1',
                'year' => '2023',
                'organic' => 14765.0916,
                'unorganic' => 16522.8406,
            ],
            [
                'id' => '1',
                'year' => '2024',
                'organic' => 14926.0566,
                'unorganic' => 16702.9681,
            ],
        );
    }
}
