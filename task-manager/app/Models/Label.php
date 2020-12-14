<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'task_label');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::create($value)->format('M d Y');
    }
}
