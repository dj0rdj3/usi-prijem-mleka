<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['domacinstvo']);

const breadcrumbs = [
    {
        title: 'Izmena domaćinstva',
        href: `/domacinstvo/${props.domacinstvo.id}/edit`,
    },
];
</script>

<template>

    <Head title="Izmena domaćinstva" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Izmena domaćinstva" description="Promenite podatke o svom domaćinstvu" />
            <form @submit.prevent="submit" class="flex flex-col gap-6 w-full max-w-sm">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="naziv">Naziv</Label>
                        <Input id="naziv" type="text" required autofocus autocomplete="name" v-model="form.naziv" placeholder="Naziv" />
                        <InputError :message="form.errors.naziv" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="adresa">Adresa</Label>
                        <Input id="adresa" type="text" required autocomplete="address" v-model="form.adresa" placeholder="Adresa" />
                        <InputError :message="form.errors.adresa" />
                    </div>

                    <div>
                        <p class="flex items-center gap-2 text-sm leading-none font-medium select-none mb-2">Precizna lokacija</p>
                        <VMap style="height: 250px;" class="rounded-xl relative" :center="domacinstvo.koordinate" zoom="15" @view-changed="handleViewUpdate">
                            <VMapOsmTileLayer />
                            <VMapZoomControl position="bottomright" />
                            <div class="z-[500] size-4 bg-blue-500 border-2 border-blue-300 rounded-full absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2"></div>
                        </VMap>
                    </div>

                    <div class="flex flex-col gap-3">
                        <p class="flex items-center gap-2 text-sm leading-none font-medium select-none">Vrste mleka koje nudite</p>
                        <div class="flex items-center justify-between">
                            <Label for="tip_kravlje" class="flex items-center">
                                <Checkbox id="tip_kravlje" v-model="tipovi_mleka.kravlje" />
                                <span>Kravlje</span>
                            </Label>
                        </div>

                        <div class="flex items-center justify-between">
                            <Label for="tip_kozije" class="flex items-center">
                                <Checkbox id="tip_kozije" v-model="tipovi_mleka.kozije" />
                                <span>Kozije</span>
                            </Label>
                        </div>

                        <div class="flex items-center justify-between">
                            <Label for="tip_ovcije" class="flex items-center">
                                <Checkbox id="tip_ovcije" v-model="tipovi_mleka.ovcije" />
                                <span>Ovčije</span>
                            </Label>
                        </div>
                        <InputError :message="form.errors.tipovi_mleka" />
                    </div>

                    <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Izmeni domaćinstvo
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import { useForm } from '@inertiajs/vue3'
import InputError from '@/components/InputError.vue'
import { Checkbox } from '@/components/ui/checkbox';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { LoaderCircle } from 'lucide-vue-next'
import { VMap, VMapOsmTileLayer, VMapZoomControl } from 'vue-map-ui';
import 'leaflet/dist/leaflet.css';
import 'vue-map-ui/dist/style.css';
import 'vue-map-ui/dist/theme-all.css';
export default {
    props: {
        domacinstvo: Object
    },
    data() {
        return {
            form: useForm({
                naziv: this.domacinstvo.naziv,
                adresa: this.domacinstvo.adresa,
                koordinate: {
                    lat: this.domacinstvo.koordinate[0],
                    lng: this.domacinstvo.koordinate[1]
                },

            }),
            tipovi_mleka: {
                kravlje: this.domacinstvo.tipovi_mleka.includes('Kravlje'),
                kozije: this.domacinstvo.tipovi_mleka.includes('Kozije'),
                ovcije: this.domacinstvo.tipovi_mleka.includes('Ovčije')
            },
        };
    },
    methods: {
        handleViewUpdate(view) {
            this.form.koordinate.lat = view.center.lat;
            this.form.koordinate.lng = view.center.lng;
        },
        submit() {
            this.form.transform((data) => ({
                ...data,
                // pretvaranje objekta tipova mleka u listu imena
                tipovi_mleka: Object.entries(this.tipovi_mleka)
                    .filter(([key, value]) => value)
                    .map(([key]) => key),
            })).put(route('domacinstvo.update', this.domacinstvo));
        }
    },
};
</script>