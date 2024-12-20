<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    protected $fillable = [
        "user_id",
        "ip_address",
        "action",
        "message"
    ];

    // Record Logging Function
    public static function record_logging($user = null, $msg)
    {
        return static::create([
            "user_id" => $user,
            "ip_address" => request()->ip(),
            "action" => request()->fullUrl(),
            "message" => $msg
        ]);
    }
}
