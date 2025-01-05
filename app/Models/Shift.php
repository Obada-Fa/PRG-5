<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */
    protected $fillable = ['title', 'description', 'start', 'end', 'location', 'status'];
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_shift')
            ->withPivot('status')
            ->withTimestamps();
    }


}

