<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';

const props = defineProps(['domacinstvo']);

const breadcrumbs = [
    {
        title: 'Vaše domaćinstvo',
        href: `/domacinstvo/${props.domacinstvo.id}`,
    },
];
</script>

<template>

    <Head title="Vaše domaćinstvo" />

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