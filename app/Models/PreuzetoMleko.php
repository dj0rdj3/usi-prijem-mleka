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
            'adresa_domacinstva' => $radniNalog->domacinstvo->adresa,
            'kolicina_mleka' => $radniNalog->kolicina_mleka,
            'procenat_mm' => $radniNalog->procenat_mm,
            'primljeno' => $radniNalog->primljeno,
            'komentar' => $radniNalog->komentar,
        ]);
    }
}
