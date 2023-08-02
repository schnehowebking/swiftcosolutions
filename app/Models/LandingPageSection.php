<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSection extends Model
{
    protected $fillable = [
        'id',
        'section_name',
        'section_order',
        'content',
        'section_type',
        'default_content',
        'section_demo_image',
        'section_blade_file_name',
    ];
}
