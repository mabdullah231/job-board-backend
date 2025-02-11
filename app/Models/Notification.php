<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model {
    use HasFactory;
    protected $fillable = ['message', 'is_read', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

