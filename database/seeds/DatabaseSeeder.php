<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

  DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
         Category::truncate();
          Product::truncate();
           Transaction::truncate();
           DB::table('category_product')->truncate();


$cantidadUsuario = 1000;
$cantidadCategories =30;
$cantidadProductos = 1000;
$cantidadTransacciones = 1000;

factory(User::class,$cantidadUsuario)->create(); 
factory(Category::class,$cantidadCategories)->create(); 
factory(Product::class,$cantidadTransacciones)->create()->each(
function($producto){
$categorias =Category::all()->random(mt_rand(1,5))->pluck('id');
$producto->categories()->attach($categorias);
}); 
factory(Transaction::class,$cantidadTransacciones)->create(); 





    }
}
