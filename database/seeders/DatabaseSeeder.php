<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DayWeek;
use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     ** @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\DayWeek::factory()->count(7)->create();

        $categories = [
            ['nome' => 'Brinquedo', 'descricao' => 'Descrição da Categoria 1'],
            ['nome' => 'Comida', 'descricao' => 'Descrição da Categoria 2'],
            ['nome' => 'Artesanato', 'descricao' => 'Descrição da Categoria 3'],
            ['nome' => 'Material Escolar', 'descricao' => 'Descrição da Categoria 4'],
            ['nome' => 'Eletronico', 'descricao' => 'Descrição da Categoria 5'],
        ];

//        $user = [
//            ['name' => 'Feirante', 'email' => 'f@f.com', 'password' => '00000000', 'type_id' => '0'],
//            ['name' => 'Admin', 'email' => 'a@a.com', 'password' => '11111111', 'type_id' => '1'],
//            ['name' => 'SuperUser', 'email' => 's@s.com', 'password' => '22222222', 'type_id' => '2'],
//        ];
//
//        User::insert($user);

        Category::insert($categories);

        $eventos = [
            ['nome' => 'Tiro ao alvo', 'descricao' => 'Descrição do Evento 1'],
            ['nome' => 'Dança de Rua', 'descricao' => 'Descrição do Evento 2'],
            ['nome' => 'Comida Indiana', 'descricao' => 'Descrição do Evento 3'],
            ['nome' => 'Beijo ou Toco', 'descricao' => 'Descrição do Evento 4'],
            ['nome' => 'Torneio Surf', 'descricao' => 'Descrição do Evento 5'],
        ];

        Event::insert($eventos);

        $products = [
            ['nome' => 'HotWells', 'category_id' => '1' , 'descricao' => 'BRINQUEDOS'],
            ['nome' => 'Barbie', 'category_id' => '1' , 'descricao' => 'ALIMENTOS'],
            ['nome' => 'Banana', 'category_id' => '2' , 'descricao' => 'ALIMENTOS'],
            ['nome' => 'Laranja', 'category_id' => '2' , 'descricao' => 'ALIMENTOS'],
            ['nome' => 'Artesanato 1', 'category_id' => '3' , 'descricao' => 'ARTESANATO'],
            ['nome' => 'Artesanato 2', 'category_id' => '3' , 'descricao' => 'ARTESANATO'],
            ['nome' => 'Artesanato 3', 'category_id' => '3' , 'descricao' => 'ARTESANATO'],
            ['nome' => 'Folhas A4', 'category_id' => '4' , 'descricao' => 'MATERIAL ESCOLAR'],
            ['nome' => 'Telefone', 'category_id' => '5' , 'descricao' => 'ELETRONICOS'],
            ['nome' => 'Computador', 'category_id' => '5' , 'descricao' => 'ELETRONICOS'],
            ['nome' => 'VideoGame', 'category_id' => '5' , 'descricao' => 'ELETRONICOS'],
        ];
        Product::insert($products);

        \App\Models\Fair::factory()->count(5)->create();

        \App\Models\Stand::factory()->count(5)->create();
        //\App\Models\FairsEvents::factory()->count(5)->create();

    }
}
