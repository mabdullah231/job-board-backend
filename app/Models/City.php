<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['city'];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'city_id');
    }
}
