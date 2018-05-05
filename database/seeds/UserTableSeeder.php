<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Model\Representative;
use Illuminate\Http\Request;

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('stores')->truncate();

        DB::table('storeretailers')->truncate();

        DB::table('storeretailereloadings')->truncate();

        DB::table('users')->insert([
            'fullname' => 'Limwel D. Libradilla',
            'contact' => '09255005872',
            'email' => 'admin',
            'username' => "admin",
            'password' => '$2y$10$Z8PchgieMxF9pGS8bszKEu4pf4JEMZpqFBQIbsH.DdqaPGl9H1TAq',
            'api_token' => 'gOGGGgsizLDSaymQYNXUAD7XTC1aGxs5O2Js9Gr8sJy3xfSMNIwT6ugWh2IX',
            'permission' => 1,
            'genealogy_id' => 0,
            'type' => 1,
            'created_at' => date("Y-m-d H:i:s"), 
            'updated_at' => date("Y-m-d H:i:s") 
        ]);
    }
}
