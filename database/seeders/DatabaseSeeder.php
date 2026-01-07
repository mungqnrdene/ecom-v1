<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);

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
            'Эрүүл мэнд & Эрүүл ахуй',
            'Бэлгийн эрүүл мэнд',
            'Цахилгаан хэрэгсэл',
            'Хүнс',
            'Ном & цомог, пянз',
            'Урлаг энтертайнмент',
            'Авто',
            'Тэжээвэр амьтны хангамж',
            'Цахим тасалбар',
            'Купон',
            'Спорт',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}