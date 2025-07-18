<?php

namespace App\Models;

use App\Enums\TipMleka;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreuzetoMleko extends Model
{
    use HasFactory;

    protected $table = 'preuzeto_mleko';

    protected $guarded = [];

    // prikaz formatirane vrste mleka pri svakom pristupu
    public function getTipMlekaAttribute($value)
    {
        foreach (TipMleka::cases() as $case) {
            if ($case->name === strtoupper($value)) {
                return $case->value;
            }
        }
    }

    public function radniNalog()
    {
        return $this->belongsTo(RadniNalog::class);
    }

    // trajno belezenje zavrsenog radnog naloga
    public static function fromRadniNalog(RadniNalog $radniNalog)
    {
        $radniNalog->load([
            'domacinstvo.vlasnik',
            'rukovodilac',
            'vozac',
            'tehnolog'
        ]);

        return self::create([
            'radni_nalog_id' => $radniNalog->id,
            'ime_rukovodioca' => $radniNalog->rukovodilac->name,
            'telefon_rukovodioca' => $radniNalog->rukovodilac->telefon,
            'ime_vozaca' => $radniNalog->vozac->name,
            'telefon_vozaca' => $radniNalog->vozac->telefon,
            'ime_tehnologa' => $radniNalog->tehnolog->name,
            'telefon_tehnologa' => $radniNalog->tehnolog->telefon,
            'ime_domacina' => $radniNalog->domacinstvo->vlasnik->name,
            'telefon_domacina' => $radniNalog->domacinstvo->vlasnik->telefon,
            'naziv_domacinstva' => $radniNalog->domacinstvo->naziv,
            'adresa_domacinstva' => $radniNalog->domacinstvo->adresa,
            'tip_mleka' => $radniNalog->tip_mleka,
            'kolicina_mleka' => $radniNalog->kolicina_mleka,
            'procenat_mm' => $radniNalog->procenat_mm,
            'primljeno' => $radniNalog->primljeno,
            'komentar' => $radniNalog->komentar,
        ]);
    }
}
