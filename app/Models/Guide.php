<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'file',
    ];

    public function getFileUrlAttribute() {
        if ($this->file && Storage::exists($this->file)) {
            return Storage::url($this->file);
        }
    }
}
