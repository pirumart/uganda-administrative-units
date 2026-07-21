<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['region', 'sub_region'];

    public function districts()
    {
        return $this->hasMany(District::class, 'region', 'region');
    }
}
