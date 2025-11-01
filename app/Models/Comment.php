<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gmail',
        'role',
        'pesan',
        'file_path',
        'file_type',
        'file_name',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
