<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
                'code' => 200,
                'writer' => 'Αλέξανδρος Παπαδιαμάντης',
                'title' => 'Οι έμποροι των εθνών',
                'publisher' => 'Γκοβόστης',
                'subject' => 'Ελληνική Πεζογραφία',
                'publish_place' => 'Αθήνα',
                'publish_year' => '1975',
                'no_of_pages' => 244,
                'acquired_by' => 'Δωρεά',
                'acquired_year' => '2020',
                'comments' => 'Μεταχειρισμένο',
                'available' => 1
            ]);
        
        Book::create([
                'code' => 201,
                'writer' => 'Steven Erikson',
                'title' => 'Gardens of the moon',
                'publisher' => 'Tor',
                'subject' => 'Φανταστική Λογοτεχνία',
                'publish_place' => 'USA',
                'publish_year' => '1999',
                'no_of_pages' => 840,
                'acquired_by' => 'Αγορά',
                'acquired_year' => '2020',
                'comments' => 'Καινούριο',
                'available' => 1
            ]);
    }
}
