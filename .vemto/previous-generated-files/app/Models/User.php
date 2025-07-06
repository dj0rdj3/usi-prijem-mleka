<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the domacinstvo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function domacinstvo()
    {
        return $this->hasOne(Domacinstvo::class);
    }

    /**
     * Get all of the radniNaloziRukovodioca.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function radniNaloziRukovodioca()
    {
        return $this->hasMany(RadniNalog::class, 'rukovodilac_id');
    }

    /**
     * Get all of the radniNaloziVozaca.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function radniNaloziVozaca()
    {
        return $this->hasMany(RadniNalog::class, 'vozac_id');
    }

    /**
     * Get all of the radniNaloziTehnologa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function radniNaloziTehnologa()
    {
        return $this->hasMany(RadniNalog::class, 'tehnolog_id');
    }
}
