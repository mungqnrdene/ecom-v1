<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Эмэгтэй',
            'Эрэгтэй',
            'Гоо сайхан',
            'Спорт & Аялал',
            'Хүүхдийн',
            'Гэрийн & Тавилга',
            'Гоёл чимэглэл',
            'Технологи',
            'Тоглоом & Хобби',
            'Бичиг хэрэг',
            'Үл хөдлөх',
            'Цахилгаан хэрэгсэл',
            'Ном & цомог, пянз',
            'Авто',
            'Тэжээвэр амьтны хангамж',
            'Цахим тасалбар',
            'Спорт',
            'Бусад',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}
