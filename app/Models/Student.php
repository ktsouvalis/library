<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [ 'surname',
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
