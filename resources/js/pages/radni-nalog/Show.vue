<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['radni_nalog']);

const breadcrumbs = [
    {
        title: `Pregled radnog naloga #${props.radni_nalog.id}`,
        href: `/radni-nalog/${props.radni_nalog.id}`,
    },
];
</script>

<template>

    <Head title="Pregled radnog naloga" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <div class="space-y-1">
                <Heading title="Pregled radnog naloga" />
                <p><span class="font-semibold">Broj naloga:</span> {{ radni_nalog.id }}</p>
                <p><span class="font-semibold">Domaćinstvo:</span> {{ radni_nalog.domacinstvo.naziv }}</p>
                <p><span class="font-semibold">Adresa:</span> {{ radni_nalog.domacinstvo.adresa }}</p>

                <p><span class="font-semibold">Domaćin:</span> {{ radni_nalog.domacinstvo.vlasnik.name }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ radni_nalog.domacinstvo.vlasnik.telefon }}</p>

                <p><span class="font-semibold">Rukovodilac:</span> {{ radni_nalog.rukovodilac.name }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ radni_nalog.rukovodilac.telefon }}</p>

                <p><span class="font-semibold">Vozač:</span> {{ radni_nalog.vozac.name }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ radni_nalog.vozac.telefon }}</p>

                <p><span class="font-semibold">Tehnolog:</span> {{ radni_nalog.tehnolog.name }}</p>
                <p><span class="ml-3 font-semibold">Telefon:</span> {{ radni_nalog.tehnolog.telefon }}</p>

                <p><span class="font-semibold">Tip mleka:</span> {{ radni_nalog.tip_mleka }}</p>
                <p><span class="font-semibold">Procenat mlečne masti:</span> {{ radni_nalog.procenat_mm ? radni_nalog.procenat_mm + ' %' : 'Nije određeno' }}</p>
                <p><span class="font-semibold">Količina mleka:</span> {{ radni_nalog.kolicina_mleka ? radni_nalog.kolicina_mleka + ' L' : 'Nije određeno' }}</p>
                <p><span class="font-semibold">Primljeno:</span> {{ radni_nalog.primljeno === null ? 'U obradi' : radni_nalog.primljeno ? 'Da' : 'Ne' }}</p>
                <p><span class="font-semibold">Komentar:</span> {{ radni_nalog.komentar }}</p>
            </div>

            <div class="w-full max-w-md mt-2">
                <VMap style="height: 300px;" class="z-5 rounded-xl" :center="radni_nalog.domacinstvo.koordinate" zoom="14">
                    <VMapOsmTileLayer />
                    <VMapZoomControl position="bottomright" />
                    <VMapMarker :latlng="radni_nalog.domacinstvo.koordinate">
                        <VMapIcon :icon-url="MarkerIcon" :shadow-url="MarkerShadow" :icon-size="[25, 41]" :icon-anchor="[12, 41]" :shadow-size="[41, 41]" />
                    </VMapMarker>
                </VMap>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import { VMap, VMapOsmTileLayer, VMapIcon, VMapZoomControl, VMapMarker } from 'vue-map-ui';
import 'leaflet/dist/leaflet.css';
import MarkerIcon from 'leaflet/dist/images/marker-icon-2x.png'
import MarkerShadow from 'leaflet/dist/images/marker-shadow.png'
import 'vue-map-ui/dist/style.css';
import 'vue-map-ui/dist/theme-all.css';
export default {
    props: {
        radni_nalog: Object
    },
};
</script>