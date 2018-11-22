<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSettingModel extends Model
{
    protected $table = 'platform_setting';
    protected $primaryKey = 'pid';
    public $timestamps = false;
}
