<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $user_id
 * @property-read string $display_name
 * @property-read string $icon_path
 */
class UserDetailEloquent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'user_details';
    protected $primaryKey = 'user_id';
    protected $fillable = ['display_name', 'icon_path'];
}
