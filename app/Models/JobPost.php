<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPost extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'location','city_id', 'job_type',
        'salary', 'deadline', 'category_id', 'company_id', 'user_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function skills() {
    //     return $this->belongsToMany(Skill::class, 'job_skills');
    // }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'job_id', 'skill_id');
    }

    public function applications() {
        return $this->hasMany(JobApplication::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function tags()
{
    return $this->belongsToMany(Tag::class, 'job_tags', 'job_id', 'tag_id');
}
}
