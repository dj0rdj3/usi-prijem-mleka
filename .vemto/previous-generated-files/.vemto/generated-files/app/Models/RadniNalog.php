<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RadniNalog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'radni_nalozi';

    protected $guarded = [];

    public function rukovodilac()
    {
        return $this->belongsTo(User::class, 'rukovodilac_id');
    }

    public function vozac()
    {
        return $this->belongsTo(User::class, 'vozac_id');
    }

    public function tehnolog()
    {
        return $this->belongsTo(User::class, 'tehnolog_id');
    }

    public function domacinstvo()
    {
        return $this->belongsTo(Domacinstvo::class);
    }

    public function preuzetoMleko()
    {
        return $this->hasOne(PreuzetoMleko::class);
    }
}
