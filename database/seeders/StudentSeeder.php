<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'user_id' => 1,
            'am' => 100,
            'surname' => 'Λάτσης',
            'name' => 'Βασίλειος',
            'f_name'=> 'Θεόδωρος',
            'class' => 'Α1' 
        ]);

        Student::create([
            'user_id' => 1,
            'am' => 101,
            'surname' => 'Τσούβαλης',
            'name' => 'Κωνσταντίνος',
            'f_name'=> 'Χρήστος',
            'class' => 'Β2' 
        ]);

        Student::create([
            'user_id' => 1,
            'am' => 102,
            'surname' => 'Στεφανόπουλος',
            'name' => 'Κωνσταντίνος',
            'f_name'=> 'Ιωάννης',
            'class' => 'Γ1' 
        ]);
    }
}
