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
                            'sec',
                            'am'
];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
