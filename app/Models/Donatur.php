<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donatur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "phone_number",
        "fundrasing_id",
        "total_amount",
        "notes",
        "is_paid",
    ];
}
