<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id',
                            'code',
                            'writer', 
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
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
