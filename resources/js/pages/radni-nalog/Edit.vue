<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;
const props = defineProps(['radni_nalog']);

const breadcrumbs = [
    {
        title: `Radni nalog #${props.radni_nalog.id}`,
        href: `/radni-nalog/${props.radni_nalog.id}/edit`,
    },
];
</script>

<template>

    <Head title="Radni nalog" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-10 mb-3">
                <div class="shrink-0 space-y-1">
                    <Heading title="Radni nalog" />
                    <p><span class="font-semibold">Broj naloga:</span> {{ radni_nalog.id }}</p>
                    <p><span class="font-semibold">Domaćinstvo:</span> {{ radni_nalog.domacinstvo.naziv }}</p>
                    <p v-if="user.tip === 'vozac'"><span class="font-semibold">Adresa:</span> {{ radni_nalog.domacinstvo.adresa }}</p>
                    <p><span class="font-semibold">Domaćin:</span> {{ radni_nalog.domacinstvo.vlasnik.name }}</p>
                    <p><span class="font-semibold">Telefon:</span> {{ radni_nalog.domacinstvo.vlasnik.telefon }}</p>
                    <p v-if="user.tip === 'tehnolog'"><span class="font-semibold">Količina mleka:</span> {{ radni_nalog.kolicina_mleka }}&nbsp;L</p>
                    <p><span class="font-semibold">Tip mleka:</span> {{ radni_nalog.tip_mleka }}</p>
                </div>

                <div v-if="user.tip === 'vozac'" class="w-full max-w-md mt-2">
                    <VMap style="height: 300px;" class="z-5 rounded-xl" :center="radni_nalog.domacinstvo.koordinate" zoom="14">
                        <VMapOsmTileLayer />
                        <VMapZoomControl position="bottomright" />
                        <VMapMarker :latlng="radni_nalog.domacinstvo.koordinate" />
                    </VMap>
                </div>
            </div>
            <hr />

            <form v-if="user.tip === 'vozac'" @submit.prevent="submitVozac" class="flex flex-col gap-6 w-full mt-2.5 sm:max-w-80">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="kolicina_mleka">Količina preuzetog mleka u L</Label>
                        <Input id="kolicina_mleka" min="1" step="1" type="number" autofocus v-model="formVozac.kolicina_mleka" placeholder="Količina u L" class="max-w-36" />
                        <InputError :message="formVozac.errors.kolicina_mleka" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="komentar">Komentar (ako nije moguće preuzeti mleko)</Label>
                        <Textarea id="komentar" rows="5" type="text" v-model="formVozac.komentar" placeholder="Sadržaj" />
                        <InputError :message="formVozac.errors.komentar" />
                    </div>

                    <Button type="submit" class="mt-2 w-full" :disabled="formVozac.processing">
                        <LoaderCircle v-if="formVozac.processing" class="h-4 w-4 animate-spin" />
                        Završi obradu
                    </Button>
                </div>
            </form>

            <form v-if="user.tip === 'tehnolog'" @submit.prevent="submitTehnolog" class="flex flex-col gap-6 w-full mt-2.5 sm:max-w-80">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="primljeno">Da li je mleko primljeno</Label>
                        <Select id="primljeno" autofocus v-model="formTehnolog.primljeno" :options="primi_opcije" placeholder="Da li je mleko primljeno" class="max-w-48" />
                        <InputError :message="formTehnolog.errors.primljeno" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="procenat_mm">Procenat mlečne masti</Label>
                        <Input id="procenat_mm" min="0.1" step="0.1" type="number" v-model="formTehnolog.procenat_mm" placeholder="Procenat mlečne masti" class="max-w-48" />
                        <InputError :message="formTehnolog.errors.procenat_mm" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="komentar">Dodatni komentar</Label>
                        <Textarea id="komentar" rows="5" type="text" v-model="formTehnolog.komentar" placeholder="Sadržaj" />
                        <InputError :message="formTehnolog.errors.komentar" />
                    </div>

                    <Button type="submit" class="mt-2 w-full" :disabled="formTehnolog.processing">
                        <LoaderCircle v-if="formTehnolog.processing" class="h-4 w-4 animate-spin" />
                        Završi obradu
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import Textarea from '@/components/Textarea.vue'
import InputError from '@/components/InputError.vue'
import { LoaderCircle } from 'lucide-vue-next'
import { Label } from '@/components/ui/label'
import Select from '@/components/Select.vue'
import { useForm } from '@inertiajs/vue3'
import { VMap, VMapOsmTileLayer, VMapZoomControl, VMapMarker } from 'vue-map-ui';
import 'leaflet/dist/leaflet.css';
import 'vue-map-ui/dist/style.css';
import 'vue-map-ui/dist/theme-all.css';
export default {
    props: {
        radni_nalog: Object
    },
    data() {
        return {
            formVozac: useForm({
                kolicina_mleka: '',
                komentar: '',
            }),
            primi_opcije: {
                1: 'Da',
                0: 'Ne',
            },
            formTehnolog: useForm({
                procenat_mm: '',
                primljeno: '',
                komentar: '',
            }),
        };
    },
    methods: {
        submitVozac() {
            this.formVozac.patch(route('radni-nalog.update', this.radni_nalog));
        },
        submitTehnolog() {
            this.formTehnolog.patch(route('radni-nalog.update', this.radni_nalog));
        },
    },
};
</script>