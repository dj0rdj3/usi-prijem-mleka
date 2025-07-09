<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Zaposleni',
        href: '/zaposleni',
    },
];
</script>

<template>

    <Head title="Zaposleni" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Zaposleni" />
            <table class="table text-left max-w-5xl">
                <thead>
                    <tr class="bg-neutral-800">
                        <th class="rounded-tl-xl pl-2 leading-8">Ime i prezime</th>
                        <th>Telefon</th>
                        <th>Pozicija</th>
                        <th class="rounded-tr-xl pl-2">Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="z in zaposleni" class="even:bg-neutral-900/90 odd:bg-neutral-900/50 border-t-1">
                        <Zaposleni :zaposleni="z" />
                    </tr>
                    <tr class="bg-neutral-800/80">
                        <td colspan="4" class="text-sm rounded-b-xl py-1.5 px-2">
                            <div class="flex justify-around">
                                <span>Ukupno zaposlenih: {{ zaposleni.length }}</span>
                                <span>Ukupno vozača: {{ ukupnoVozaca }}</span>
                                <span>Ukupno tehnologa: {{ ukupnoTehnologa }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import Zaposleni from '@/components/Zaposleni.vue'
export default {
    props: {
        zaposleni: Object,
    },
    data() {
        return {
            ukupnoVozaca: this.zaposleni?.filter((z) => z?.tip === 'vozac').length,
            ukupnoTehnologa: this.zaposleni?.filter((z) => z?.tip === 'tehnolog').length,
        };
    },
};
</script>