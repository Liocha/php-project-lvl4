<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function task()
    {
        return $this->hasMany('App\Models\Task', 'status_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->format('M d Y');
    }
}
