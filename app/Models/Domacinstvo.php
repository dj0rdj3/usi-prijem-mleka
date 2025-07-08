<?php

namespace App\Models;

use App\Enums\TipMleka;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domacinstvo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'domacinstva';

    protected $guarded = [];

    public function getKoordinateAttribute($value)
    {
        return explode(',', $value);
    }

    public function getTipoviMlekaAttribute($value)
    {
        return array_map(function ($name) {
            foreach (TipMleka::cases() as $case) {
                if ($case->name === strtoupper($name)) {
                    return $case->value;
                }
            }
            return null;
        }, explode(',', $value));
    }

    public function vlasnik()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function radniNalozi()
    {
        return $this->hasMany(RadniNalog::class);
    }
}
