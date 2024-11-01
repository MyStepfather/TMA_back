<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Company;
use App\Models\Device;
use App\Models\Document;
use App\Models\EventType;
use App\Models\OpozdunType;
use App\Models\Presentation;
use App\Models\Requisite;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MoonShine\Models\MoonshineUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        MoonshineUser::factory()->create([
            'moonshine_user_role_id' => 1,
            'email' => 'ilya@ya.ru',
            'password' => Hash::make('123'),
            'name' => 'Илья',
        ]);

        CategoryType::factory()->create([
            'type' => 'devices',
            'title' => 'Оборудование'
        ]);
        CategoryType::factory()->create([
            'type' => 'documents',
            'title' => 'Документы'
        ]);
        CategoryType::factory()->create([
            'type' => 'presentations',
            'title' => 'Презентации'
        ]);
        Category::factory()->create([
            'title' => 'Мультимедиа',
            'category_type_id' => 1,
        ]);
        Category::factory()->create([
            'title' => 'Интерактив',
            'category_type_id' => 1,
        ]);
        Category::factory()->create([
            'title' => 'Схема сборки',
            'category_type_id' => 2,
        ]);
        Category::factory()->create([
            'title' => 'Схема уборки',
            'category_type_id' => 2,
        ]);
        Category::factory()->create([
            'title' => 'Ивенты',
            'category_type_id' => 3,
        ]);
        Category::factory()->create([
            'title' => 'О компании',
            'category_type_id' => 3,
        ]);
        Company::factory()->create([
            'name' => 'ООО Гефест Капитал'
        ]);
        Company::factory()->create([
            'name' => 'ИП Кодриков'
        ]);

        $presentation_1 = Presentation::factory()->create([
            'title' => 'Ивенты',
            'path' => 'presentations/dMZaKDSoXO.pdf',
            'company_id' => 1,
        ]);
        $category_1 = Category::where('title', 'Интерактив')->first();
        $presentation_1->categories()->attach($category_1->id);
        $presentation_2 = Presentation::factory()->create([
            'title' => 'Ивенты',
            'path' => 'presentations/kyZmYqAHCs.pdf',
            'company_id' => 2,
        ]);
        $category_2 = Category::where('title', 'О компании')->first();
        $presentation_2->categories()->attach($category_2->id);

        $device_1 = Device::factory()->create([
            'title' => 'Селфи 360',
            'thumb' => 'images/devices/thumbnails/bVsrXVyT2a.png',
            'gallery' => [
                'images/devices/gallery/3QLkog60Yv.jpg',
                'images/devices/gallery/3Dx8LwY41D.png',
                'images/devices/gallery/Cz7dq2YvM3.png',
            ]
        ]);
        $category_1 = Category::where('title', 'Ивенты')->first();
        $document_1 = Document::factory()->create([
            'device_id' => $device_1->id,
            'category_id' => 3,
            'title' => 'Какой-то документ',
            'path' => 'documents/dMZaKDSoXO.pdf',
        ]);
        $device_1->categories()->attach($category_1->id);
        $document_1->device_id = $device_1->id;

        $device_2 = Device::factory()->create([
            'title' => 'Интерактивный пол',
            'thumb' => 'images/devices/thumbnails/8e7z9VZ3br.jpg',
            'gallery' => [
                'images/devices/gallery/3QLkog60Yv.jpg',
                'images/devices/gallery/3Dx8LwY41D.png',
                'images/devices/gallery/Cz7dq2YvM3.png',
            ]
        ]);
        $category_2 = Category::where('title', 'Мультимедиа')->first();
        $document_2 = Document::factory()->create([
            'device_id' => $device_2->id,
            'category_id' => 4,
            'title' => 'Какой-то документ',
            'path' => 'documents/dMZaKDSoXO.pdf',
        ]);
        $device_2->categories()->attach($category_2->id);
        $document_2->device_id = $device_2->id;

        $requisites = [
            'Номер счета' => 12308,
            'БИК' => 111111111,
            'ИНН' => 234141423131,
            'КПП' => 23131341541
        ];
        $encode = json_encode($requisites);
        Requisite::factory()->create([
            'company_id' => 1,
            'date' => Carbon::now(),
            'entities' => json_decode($encode),
            'path' => 'documents/dMZaKDSoXO.pdf',
            'title' => 'Ячсмить'
        ]);

        $requisites_2 = [
            'Номер счета' => 123,
            'БИК' => 234,
            'ИНН' => 345,
            'КПП' => 456
        ];
        $encode = json_encode($requisites_2);
        Requisite::factory()->create([
            'company_id' => 2,
            'date' => Carbon::now(),
            'entities' => json_decode($encode),
            'path' => 'documents/dMZaKDSoXO.pdf',
            'title' => 'Ячсмить 2'
        ]);
        EventType::factory()->create([
            'type' => 'birthday',
            'title' => 'День Рождения'
        ]);
        OpozdunType::factory()->create([
            'name' => 'Буду позже'
        ]);
        OpozdunType::factory()->create([
            'name' => 'Опаздываю'
        ]);
        OpozdunType::factory()->create([
            'name' => 'Заболел'
        ]);
        OpozdunType::factory()->create([
            'name' => 'На удаленке'
        ]);
        OpozdunType::factory()->create([
            'name' => 'Командировка'
        ]);
        OpozdunType::factory()->create([
            'name' => 'Отпуск'
        ]);
        OpozdunType::factory()->create([
            'name' => 'День за свой счет'
        ]);
    }
}
