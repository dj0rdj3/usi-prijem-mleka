<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ugovor o saradnji',
        href: '/ugovor',
    },
];
</script>

<template>

    <Head title="Ugovor o saradnji" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-3 rounded-xl p-4 overflow-x-auto">
            <Heading title="Ugovor o saradnji" description="Prihvatanje uslova za prijem mleka" />
            <p><strong>1. Ugovorne strane:</strong><br>
                Ovaj ugovor se zaključuje između:<br>
                <strong>Otkupljivača</strong> (mlekare) i<br>
                <strong>Isporučioca mleka</strong> (domaćina)
            </p>

            <p><strong>2. Predmet ugovora:</strong><br>
                Isporučilac se obavezuje da svakodnevno isporučuje sveže kravlje mleko Otkupljivaču, a Otkupljivač se obavezuje da mleko preuzme i evidentira u skladu sa internim procedurama prijema.
            </p>

            <div>
                <p><strong>3. Kvalitet mleka:</strong></p>
                <ul class="list-disc list-inside">
                    <li>sveže i higijenski ispravno</li>
                    <li>bez primesa i antibiotika</li>
                    <li>rashlađeno na maksimalno 8°C</li>
                </ul>
                <p>Otkupljivač zadržava pravo da odbije mleko koje ne ispunjava standarde.</p>
            </div>

            <div>
                <p><strong>4. Raspored prijema:</strong></p>
                <ul class="list-disc list-inside">
                    <li>Preuzimanje mleka se vrši <strong>svakog dana</strong> na dogovorenoj lokaciji</li>
                    <li>Svaka isporuka se meri i evidentira putem elektronskog sistema prijema mleka</li>
                </ul>
            </div>

            <div>
                <p><strong>5. Raskid saradnje:</strong></p>
                <ul class="list-disc list-inside">
                    <li>Isporučilac može <strong>u svakom trenutku</strong> jednostrano raskinuti ugovor bez navođenja razloga, putem dugmeta za prekid koje mu je dostupno na sajtu.</li>
                    <li>Otkupljivač može raskinuti ugovor uz pisano obaveštenje, s otkaznim rokom od 30 dana, ili odmah u slučaju kršenja uslova (npr. nekvalitetno mleko).</li>
                </ul>
            </div>

            <p><strong>6. Prihvatanje ugovora:</strong><br>
                Klikom na <strong>checkbox</strong> u online formi, Isporučilac potvrđuje da je pročitao, razumeo i prihvatio sve uslove ovog ugovora. Ugovor stupa na snagu danom prihvatanja.
            </p>
        </div>
    </AppLayout>
</template>
