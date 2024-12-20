<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookLoan extends Model
{
    const pending_status = 1;
    const approved_status = 2;
    const completed_status = 3;

    protected $table = 'tbl_peminjaman_buku';

    protected $fillable = [
        'book_id',
        'student_id',
        'start_date',
        'end_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'book_id' => 'integer',
        'student_id' => 'integer'
    ];

    public static function booted(): void
    {
        static::saving(function ($model) {
            if ($model->status == self::completed_status && !$model->return_date) {
                $model->return_date = Carbon::now();
            }
        });
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
