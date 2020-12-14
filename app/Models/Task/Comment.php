<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by_id');
    }
}
