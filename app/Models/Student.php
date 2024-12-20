<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User;

class Student extends User
{
    protected $table = 'tbl_mahasiswa';

    protected $fillable = [
        'name',
        'nim',
        'password',
        'academic_id',
        'jenis_kelamin',
        'gender'
    ];

    protected $casts = [
        'academic_id' => 'integer'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = ucwords(strtolower($model->name));
        });
    }

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class, 'academic_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'tbl_kategori_mahasiswa');
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class, 'student_id');
    }
}
