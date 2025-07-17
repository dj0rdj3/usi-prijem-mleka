<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Izdavanje radnog naloga',
        href: '/radni-nalog/create',
    },
];
</script>

<template>

    <Head title="Izdavanje radnog naloga" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Izdavanje radnog naloga" description="" />
            <form @submit.prevent="submit" class="flex flex-col gap-6 w-full max-w-sm">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="domacinstvo">Domaćinstvo</Label>
                        <Select id="domacinstvo" required v-model="form.domacinstvo_id" :options="domacinstva_list" placeholder="Izaberi domaćinstvo" />
                        <InputError :message="form.errors.domacinstvo_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="tip_mleka">Tip mleka</Label>
                        <Select id="tip_mleka" required v-model="form.tip_mleka" :disabled="!form.domacinstvo_id" :options="tipovi_mleka[form.domacinstvo_id]" placeholder="Izaberi tip mleka" />
                        <InputError :message="form.errors.tip_mleka" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="vozac">Vozač</Label>
                        <Select id="vozac" required v-model="form.vozac_id" :options="vozaci_list" placeholder="Izaberi vozača" />
                        <InputError :message="form.errors.vozac_id" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="tehnolog">Tehnolog</Label>
                        <Select id="tehnolog" required v-model="form.tehnolog_id" :options="tehnolozi_list" placeholder="Izaberi tehnologa" />
                        <InputError :message="form.errors.tehnolog_id" />
                    </div>

                    <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Pošalji nalog
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
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { LoaderCircle } from 'lucide-vue-next'
import Select from '@/components/Select.vue';
export default {
    props: {
        domacinstva: Object,
        vozaci: Object,
        tehnolozi: Object,
    },
    data() {
        return {
            form: useForm({
                domacinstvo_id: '',
                vozac_id: '',
                tehnolog_id: '',
                tip_mleka: '',
            }),
            // konvertovanje liste tipova mleka svakog domacinstva u format zahtevan za select
            tipovi_mleka: Object.assign({}, ...this.domacinstva.map((d) => {
                const svi_tipovi_mleka = {
                    'Kravlje': 'kravlje',
                    'Kozije': 'kozije',
                    'Ovčije': 'ovcije',
                };
                return {
                    [d.id]: d.tipovi_mleka.reduce((acc, key) => {
                        const converted = svi_tipovi_mleka[key];
                        if (converted) acc[converted] = key;
                        return acc;
                    }, {})
                };
            })),
            // mapiranje ID-ja i naziva, za select
            domacinstva_list: Object.assign({}, ...this.domacinstva.map((d) => {
                return { [d.id]: d.naziv };
            })),
            vozaci_list: Object.assign({}, ...this.vozaci.map((d) => {
                return { [d.id]: d.name };
            })),
            tehnolozi_list: Object.assign({}, ...this.tehnolozi.map((d) => {
                return { [d.id]: d.name };
            })),
        };
    },
    methods: {
        submit() {
            this.form.post(route('radni-nalog.store'));
        }
    },
};
</script>