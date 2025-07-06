<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domacinstvo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'domacinstva';

    protected $guarded = [];

    public function vlasnik()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function radniNalozi()
    {
        return $this->hasMany(RadniNalog::class);
    }
}
