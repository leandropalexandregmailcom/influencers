<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Influencer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'instagram_handle', 'followers_count', 'category_id'];

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_influencer');
    }
}
