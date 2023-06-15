<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicVisit extends Model
{
    use HasFactory;

    protected $table = 'public_visit_counter';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
