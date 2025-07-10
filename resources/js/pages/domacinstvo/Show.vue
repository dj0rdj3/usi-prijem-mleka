<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';

const props = defineProps(['domacinstvo']);

const breadcrumbs = [
    {
        title: 'Moje domaćinstvo',
        href: `/domacinstvo/${props.domacinstvo.id}`,
    },
];
</script>

<template>

    <Head title="Moje domaćinstvo" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-10 mb-3">
                <div class="shrink-0">
                    <Heading :title="domacinstvo.naziv" :description="domacinstvo.adresa" class="max-w-xs" />

                    <div>
                        <h4 class="font-semibold">Vrste mleka koje nudite:</h4>
                        <ul class="list-disc list-inside">
                            <li class="text-sm" v-for="tip in domacinstvo.tipovi_mleka" v-text="tip"></li>
                        </ul>

                        <Button class="my-3">
                            <TextLink nostyle :href="route('domacinstvo.edit', domacinstvo)">Izmeni domaćinstvo</TextLink>
                        </Button>
                        <br />
                        <ObrisiDomacinstvo :domacinstvo="domacinstvo" />
                    </div>
                </div>

                <div class="w-full max-w-sm mt-2">
                    <VMap style="height: 250px;" class="z-5 rounded-xl" :center="domacinstvo.koordinate" zoom="15">
                        <VMapOsmTileLayer />
                        <VMapZoomControl position="bottomright" />
                        <VMapMarker :latlng="domacinstvo.koordinate" />
                    </VMap>
                </div>
            </div>
            <hr />

            <Heading title="Istorija prijema mleka" class="mt-2" />
            <table class="-mt-2 table text-left max-w-7xl">
                <thead>
                    <tr class="bg-neutral-800">
                        <th class="rounded-tl-xl pl-2 leading-8">Datum</th>
                        <th>Vrsta mleka</th>
                        <th>Količina mleka</th>
                        <th>Procenat mlečne masti</th>
                        <th>Primljeno</th>
                        <th class="rounded-tr-xl pr-2">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="nalog in domacinstvo.radni_nalozi" class="even:bg-neutral-900/90 odd:bg-neutral-900/50 border-t-1">
                        <td class="pl-2 py-2.5" v-text="(new Date(nalog.created_at)).toLocaleDateString('sr')"></td>
                        <td v-text="nalog.tip_mleka"></td>
                        <td v-text="nalog.kolicina_mleka ? nalog.kolicina_mleka + ' L' : '-'"></td>
                        <td v-text="nalog.procenat_mm ? nalog.procenat_mm + ' %' : '-'"></td>
                        <td>
                            <p v-text="nalog.primljeno ? 'Da' : 'Ne'" class="inline-flex px-2 rounded-full border-2 font-semibold" :class="[nalog.primljeno ? 'bg-green-600 border-green-400' : 'bg-red-600 border-red-400']"></p>
                        </td>
                        <td class="pr-2 py-2.5" v-text="nalog.komentar"></td>
                    </tr>
                    <tr class="bg-neutral-800/80">
                        <td colspan="6" class="text-sm rounded-b-xl py-1.5 px-2 text-center">
                            <p>Ukupno: {{ domacinstvo.radni_nalozi?.length }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import ObrisiDomacinstvo from '@/components/ObrisiDomacinstvo.vue'
import { VMap, VMapOsmTileLayer, VMapZoomControl, VMapMarker } from 'vue-map-ui';
import 'leaflet/dist/leaflet.css';
import 'vue-map-ui/dist/style.css';
import 'vue-map-ui/dist/theme-all.css';
export default {
    props: {
        domacinstvo: Object
    },
};
</script>