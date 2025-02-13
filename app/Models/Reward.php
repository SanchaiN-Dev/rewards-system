<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points_required',
        'valid_until',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
