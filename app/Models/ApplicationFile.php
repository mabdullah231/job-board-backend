<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationFile extends Model {
    use HasFactory;
    protected $fillable = ['file_path', 'application_id'];

    public function application() {
        return $this->belongsTo(JobApplication::class);
    }
}
