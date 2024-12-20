<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table = 'tbl_tipe_repositori';

    protected $fillable = [
        'name',
        'status'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = ucwords(strtolower($model->name));
        });
    }

    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class, 'type_id');
    }
}
