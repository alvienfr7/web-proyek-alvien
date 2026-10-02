<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'tanggal_rilis', 'sampul'];

    protected function casts(): array
    {
        return [
            'tanggal_rilis' => 'date',
        ];
    }

    public function scopeCari(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function (Builder $q, string $keyword) {
            // addcslashes mencegah karakter % dan _ diartikan sebagai wildcard
            $aman = addcslashes($keyword, '%_\\');

            $q->where('judul', 'like', "%{$aman}%");
        });
    }
}