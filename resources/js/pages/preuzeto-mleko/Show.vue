<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';

const props = defineProps(['preuzeto_mleko']);

const breadcrumbs = [
    {
        title: `Pregled preuzetog mleka`,
        href: `/preuzeto-mleko/${props.preuzeto_mleko.id}`,
    },
];
</script>

<template>

    <Head title="Pregled preuzetog mleka" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <div class="space-y-1">
                <Heading title="Pregled preuzetog mleka" />
                <p><span class="font-semibold">Broj preuzetog mleka:</span> {{ preuzeto_mleko.id }}</p>
                <p><span class="font-semibold">Broj radnog naloga:</span>&nbsp;
                    <TextLink :href="route('radni-nalog.show', preuzeto_mleko.radni_nalog_id)" v-text="preuzeto_mleko.radni_nalog_id" />
                </p>

                <p><span class="font-semibold">Domaćinstvo:</span> {{ preuzeto_mleko.naziv_domacinstva }}</p>
                <p><span class="font-semibold">Adresa:</span> {{ preuzeto_mleko.adresa_domacinstva }}</p>

                <p><span class="font-semibold">Domaćin:</span> {{ preuzeto_mleko.ime_domacina }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ preuzeto_mleko.telefon_domacina }}</p>

                <p><span class="font-semibold">Rukovodilac:</span> {{ preuzeto_mleko.ime_rukovodioca }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ preuzeto_mleko.telefon_rukovodioca }}</p>

                <p><span class="font-semibold">Vozač:</span> {{ preuzeto_mleko.ime_vozaca }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ preuzeto_mleko.telefon_vozaca }}</p>

                <p><span class="font-semibold">Tehnolog:</span> {{ preuzeto_mleko.ime_tehnologa }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ preuzeto_mleko.telefon_tehnologa }}</p>

                <p><span class="font-semibold">Tip mleka:</span> {{ preuzeto_mleko.tip_mleka }}</p>
                <p><span class="font-semibold">Procenat mlečne masti:</span> {{ preuzeto_mleko.procenat_mm ? preuzeto_mleko.procenat_mm + ' %' : 'Nije određeno' }}</p>
                <p><span class="font-semibold">Količina mleka:</span> {{ preuzeto_mleko.kolicina_mleka ? preuzeto_mleko.kolicina_mleka + ' L' : 'Nije određeno' }}</p>
                <p><span class="font-semibold">Primljeno:</span> {{ preuzeto_mleko.primljeno ? 'Da' : 'Ne' }}</p>
                <p><span class="font-semibold">Komentar:</span> {{ preuzeto_mleko.komentar }}</p>
                <p><span class="font-semibold">Datum:</span> {{ (new Date(preuzeto_mleko.created_at)).toLocaleDateString('sr') }}</p>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
export default {
    props: {
        preuzeto_mleko: Object
    },
};
</script>