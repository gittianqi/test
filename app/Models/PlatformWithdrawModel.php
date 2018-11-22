<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformWithdrawModel extends Model
{
    protected $table = 'platform_withdraw';
    public $fillable = ['status', 'operator','operator_name'];
}
