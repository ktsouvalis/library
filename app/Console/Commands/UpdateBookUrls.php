<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class UpdateBookUrls extends Command
{
    protected $signature = 'books:update-urls';

    protected $description = 'Update the URL field for all books';

    public function handle()
    {
        $books = Book::all();

        foreach ($books as $book) {
            $url = Str::lower(trim($book->title));
            $url = Str::replace(' ', '_', $url);
            $url = Str::ascii($url).$book->id;

            $book->url=$url;
            $book->save();
        }

        $this->info('Book URLs updated successfully.');
    }
}
