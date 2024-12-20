<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    protected $table = 'tbl_repository';

    protected $fillable = [
        'code',
        'student_id',
        'title',
        'abstract',
        'keywords',
        'type_id',
        'academic_id'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->title = ucwords(strtolower($model->title));
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class, 'academic_id');
    }
}
