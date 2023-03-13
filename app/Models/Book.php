<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [ 'writer', 
                            'title',
                            'publisher',
                            'subject',
                            'publish_place',
                            'publish_year',
                            'no_of_pages',
                            'acquired_by',
                            'acquired_year',
                            'comments',
                            'available'
];

}
