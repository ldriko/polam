<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'url',
        'image',
    ];

    function getImageUrlAttribute() {
        if ($this->image && Storage::exists($this->image)) {
            return asset($this->image);
        }

        return asset('website/img/ttd/placeholder.png');
    }
}
