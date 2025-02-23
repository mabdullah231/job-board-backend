<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];

    public function jobs()
    {
        return $this->belongsToMany(JobPost::class, 'job_skills', 'skill_id', 'job_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills');
    }
}
