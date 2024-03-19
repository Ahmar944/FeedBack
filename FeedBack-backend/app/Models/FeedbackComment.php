<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackComment extends Model
{
    protected $fillable = ['feedback_id', 'user_id', 'content'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
