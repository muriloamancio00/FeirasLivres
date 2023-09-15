<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DayWeek;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     ** @return void
     */
    public function run()
    {
        \App\Models\Type::factory(2)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Permission::factory(40)->create();
        \App\Models\DayWeek::factory()->count(7)->create();

        $categories = [
            ['nome' => 'Brinquedo', 'descricao' => 'Descrição da Categoria 1'],
            ['nome' => 'Comida', 'descricao' => 'Descrição da Categoria 2'],
            ['nome' => 'Artesanato', 'descricao' => 'Descrição da Categoria 3'],
            ['nome' => 'Material Escolar', 'descricao' => 'Descrição da Categoria 4'],
            ['nome' => 'Eletronico', 'descricao' => 'Descrição da Categoria 5'],
        ];

        Category::insert($categories);

        $eventos = [
            ['nome' => 'Tiro ao alvo', 'descricao' => 'Descrição do Evento 1'],
            ['nome' => 'Dança de Rua', 'descricao' => 'Descrição do Evento 2'],
            ['nome' => 'Comida Indiana', 'descricao' => 'Descrição do Evento 3'],
            ['nome' => 'Beijo ou Toco', 'descricao' => 'Descrição do Evento 4'],
            ['nome' => 'Torneio Surf', 'descricao' => 'Descrição do Evento 5'],
        ];

        Event::insert($eventos);

        \App\Models\Fair::factory()->count(5)->create();

        \App\Models\Stand::factory()->count(5)->create();
        \App\Models\Product::factory()->count(30)->create();
        //\App\Models\FairEvent::factory()->count(5)->create();

    }
}
