<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id',
                            'surname',
                            'name',
                            'f_name',
                            'class',
                            'am',
                            'bm'
];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function hasActiveLoan(){
        return $this->loans()->whereNull('date_in')->exists();
    }
}
