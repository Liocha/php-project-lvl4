<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','status_id', 'assigned_to_id'];

    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\TaskStatus', 'id', 'status_id');
    }

    public function assignee()
    {
        return $this->hasOne('App\Models\User', 'id', 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Models\Label', 'task_label');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Task\Comment');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->format('M d Y');
    }
}
