<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [ 'book_id',
                            'student_id',
                            'date_out',
                            'date_in'
];

    public function book(){
        return $this->belongsTo(Book::class,'book_id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
}
