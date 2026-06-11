<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Dompet',
            'Tas Selempang & Bahu Wanita',
            'Dompet Wanita',
            'Tas Selempang & Bahu Pria',
            'Clutch/Handbag',
            'Gantungan Kunci',
            'Aksesoris Dompet Make Up',
            'Tas Pinggang Pria/Waistbag',
            'Ikat Pinggang',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
