<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
    protected $table = 'tbl_kategori_mahasiswa';

    protected $fillable = [
        'student_id',
        'category_id'
    ];

    protected $casts = [
        'student_id' => 'integer',
        'category_id' => 'integer'
    ];
}
