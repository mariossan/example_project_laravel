<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id'];

    public function image()
    {
        return $this->morphOne(Image::class,'imageable')->withDefault();
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }
}
