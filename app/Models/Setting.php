<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'site_name',
        'system_email',
        'contact_phone',
        'academic_year',
    ];

    /**
     * Default settings used when bootstrapping the application.
     *
     * @return array<string, string|null>
     */
    public static function defaults(): array
    {
        return [
            'site_name' => 'Students Management System',
            'system_email' => 'info@example.com',
            'contact_phone' => '+000 000 0000',
            'academic_year' => '2025',
        ];
    }
}

