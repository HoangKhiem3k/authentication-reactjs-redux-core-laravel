<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
      'name',
      'start_time',
      'end_time',
      'budget',
      'bid_amount',
      'title',
      'description',
      'banner',
      'final_url',
      'user_id',
      'used_amount',
      'usage_rate',
      'status',
      'is_deleted',
    ];
}

