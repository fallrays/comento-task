<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardComment extends Model
{
    use HasFactory;

    protected $table = 'boards_comments';
}
