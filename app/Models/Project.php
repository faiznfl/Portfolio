<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tech_stacks' => 'array',
            'gallery_images' => 'array',
            'key_metrics' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order_index' => 'integer',
        ];
    }
}
