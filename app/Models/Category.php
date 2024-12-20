<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'tbl_kategori';

    protected $fillable = [
        'name'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = ucwords(strtolower($model->name));
        });
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'tbl_kategori_mahasiswa');
    }
}
