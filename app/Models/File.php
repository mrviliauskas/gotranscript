<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App\Models
 */
class File extends Model
{
    const PATH_USER_UPLOADS = 'uploads';
    const ITEMS_PER_PAGE = 10;

    protected $fillable = [
        'path',
        'original_name',
        'valid_from'
    ];

    protected $table = 'files';
}
