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
            'name' => 'ktsouvalis',
            'display_name' => 'Κωνσταντίνος Τσούβαλης',
            'email' => 'ktsouvalis@sch.gr',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'kstefanopoulos',
            'display_name' => 'Κωνσταντίνος Στεφανόπουλος',
            'email' => 'konstantinostef@yahoo.gr',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'test',
            'display_name' => 'Δοκιμαστικό Σχολείο',
            'email' => 'plinet_pe@dipe.ach.sch.gr',
            'password' => bcrypt('123456') 
        ]);
    }
}
