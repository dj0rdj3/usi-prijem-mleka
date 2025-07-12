<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Dashboard" description="Pregled svih funkcija prijema mleka." />

            <div class="flex flex-wrap items-center gap-4 justify-center mb-10">
                <CardLink :href="route('radni-nalog.create')" icon="NotebookPen">Izdavanje radnog naloga</CardLink>
                <CardLink :href="route('radni-nalog.index')" icon="Folders">Radni nalozi</CardLink>
                <CardLink :href="route('zaposleni.index')" icon="SquareUserRound">Zaposleni</CardLink>
                <CardLink :href="route('preuzeto-mleko.index')" icon="Logs">Preuzeto mleko</CardLink>
            </div>

            <div class="flex flex-wrap items-center gap-4 justify-center mb-10">
                <StatCard title="Domaćinstava" :value="stats.broj_domacinstava" />
                <StatCard title="Radnih naloga" :value="stats.broj_radnih_naloga" />
                <StatCard title="Vozača" :value="stats.broj_vozaca" />
                <StatCard title="Tehnologa" :value="stats.broj_tehnologa" />
            </div>

            <Heading title="Statistika za prethodnu nedelju" class="text-center" />
            <div class="flex flex-wrap items-center gap-4 justify-center mb-10">
                <MultiStatCard mainTitle="Litara primljenog mleka" :stats="stats.kolicina_primljenog_mleka_nedelja" />
                <StatCard title="Litara preuzetog mleka" :value="stats.ukupno_preuzetog_mleka_nedelja" />
                <MultiStatCard mainTitle="Litara odbijenog mleka" :stats="stats.kolicina_odbijenog_mleka_nedelja" />
            </div>

            <Heading title="Statistika za prethodni mesec" class="text-center" />
            <div class="flex flex-wrap items-center gap-4 justify-center mb-10">
                <MultiStatCard mainTitle="Litara primljenog mleka" :stats="stats.kolicina_primljenog_mleka_mesec" />
                <StatCard title="Litara preuzetog mleka" :value="stats.ukupno_preuzetog_mleka_mesec" />
                <MultiStatCard mainTitle="Litara odbijenog mleka" :stats="stats.kolicina_odbijenog_mleka_mesec" />
            </div>

            <Heading title="Statistika za prethodnu godinu" class="text-center" />
            <div class="flex flex-wrap items-center gap-4 justify-center">
                <MultiStatCard mainTitle="Litara primljenog mleka" :stats="stats.kolicina_primljenog_mleka_godina" />
                <StatCard title="Litara preuzetog mleka" :value="stats.ukupno_preuzetog_mleka_godina" />
                <MultiStatCard mainTitle="Litara odbijenog mleka" :stats="stats.kolicina_odbijenog_mleka_godina" />
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import StatCard from '@/components/StatCard.vue'
import MultiStatCard from '@/components/MultiStatCard.vue'
import CardLink from '@/components/CardLink.vue';
export default {
    props: {
        stats: Object,
    },
};
</script>