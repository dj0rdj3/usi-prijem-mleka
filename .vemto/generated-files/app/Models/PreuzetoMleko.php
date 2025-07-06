<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreuzetoMleko extends Model
{
    use HasFactory;

    protected $table = 'preuzeto_mleko';

    protected $guarded = [];

    public function radniNalog()
    {
        return $this->belongsTo(RadniNalog::class);
    }
}
