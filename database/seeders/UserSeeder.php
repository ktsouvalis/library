<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin45',
            'display_name' => '45ο Δημοτικό Σχολείο Πάτρας',
            'email' => 'mail@45dim-patras.ach.sch.gr',
            'password' => bcrypt('45dimpat!!') 
        ]);

        User::create([
            'name' => 'ktsouvalis',
            'display_name' => 'Κωνσταντίνος Τσούβαλης',
            'email' => 'ktsouvalis@sch.gr',
            'password' => bcrypt('123456')
    ]);
    }
}
