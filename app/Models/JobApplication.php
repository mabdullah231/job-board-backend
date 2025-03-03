<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','email','cover_letter', 'status', 'user_id', 'job_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function file()
    {
        return $this->hasOne(ApplicationFile::class, 'application_id','id');
    }
}
