<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';

const breadcrumbs = [
    {
        title: 'Preuzeto mleko',
        href: '/preuzeto-mleko',
    },
];
</script>

<template>

    <Head title="Preuzeto mleko" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Preuzeto mleko" />
            <table class="-mt-2 table text-left w-full">
                <thead>
                    <tr class="bg-neutral-800">
                        <th class="rounded-tl-xl pl-2 leading-8">Pregled</th>
                        <th>Datum</th>
                        <th>Domaćinstvo</th>
                        <th>Vrsta mleka</th>
                        <th>Količina mleka</th>
                        <th>Procenat mlečne masti</th>
                        <th>Primljeno</th>
                        <th class="rounded-tr-xl pr-2">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="preuzeto in preuzeto_mleko" class="even:bg-neutral-900/90 odd:bg-neutral-900/50 border-t-1">
                        <td class="pl-2 py-2.5">
                            <TextLink :href="route('preuzeto-mleko.show', preuzeto.id)">Pregledaj</TextLink>
                        </td>
                        <td v-text="(new Date(preuzeto.created_at)).toLocaleDateString('sr')"></td>
                        <td v-text="preuzeto.naziv_domacinstva"></td>
                        <td v-text="preuzeto.tip_mleka"></td>
                        <td v-text="preuzeto.kolicina_mleka ? preuzeto.kolicina_mleka + ' L' : '-'"></td>
                        <td v-text="preuzeto.procenat_mm ? preuzeto.procenat_mm + ' %' : '-'"></td>
                        <td>
                            <p v-text="preuzeto.primljeno ? 'Da' : 'Ne'" class="inline-flex px-2 rounded-full border-2 font-semibold" :class="[preuzeto.primljeno ? 'bg-green-600 border-green-400' : 'bg-red-600 border-red-400']"></p>
                        </td>
                        <td class="pr-2 py-2.5" v-text="preuzeto.komentar?.length > 20 ? preuzeto.komentar?.slice(0, 20) + '&hellip;' : preuzeto.komentar"></td>
                    </tr>
                    <tr class="bg-neutral-800/80">
                        <td colspan="8" class="text-sm rounded-b-xl py-1.5 px-2 text-center">
                            <p>Ukupno: {{ preuzeto_mleko.length }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
export default {
    props: {
        preuzeto_mleko: Object,
    },
};
</script>