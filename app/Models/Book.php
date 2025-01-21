<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    const easy_level = 1;
    const medium_level = 2;
    const hard_level = 3;

    protected $table = 'tbl_buku';

    protected $fillable = [
        'name',
        'author',
        'description',
        'location',
        'image',
        'stock',
        'borrowed',
        'category_id',
        'academic_id',
        'level'
    ];

    protected $casts = [
        'stock' => 'integer',
        'borrowed' => 'integer',
        'category_id' => 'integer',
        'academic_id' => 'integer',
        'level' => 'integer'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = ucwords(strtolower($model->name));
            $model->author = ucwords(strtolower($model->author));
            $model->description = ucwords(strtolower($model->description));
            $model->location = ucwords(strtolower($model->location));
        });
    }

    public function calculateAvgRating()
    {
        return $this->hasMany(BookRating::class, 'book_id')
            ->avg('rating');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class, 'academic_id');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class, 'book_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(BookRating::class, 'book_id');
    }
}
