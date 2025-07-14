<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;
const breadcrumbs = [
    {
        title: 'Radni nalozi',
        href: '/radni-nalog',
    },
];
</script>

<template>

    <Head title="Radni nalozi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Radni nalozi" />
            <table class="-mt-2 table text-left w-full">
                <thead>
                    <tr class="bg-neutral-800">
                        <th class="rounded-tl-xl pl-2 leading-8">Radni nalog</th>
                        <th>Akcija</th>
                        <th>Domaćinstvo</th>
                        <th v-if="user.tip === 'vozac'">Adresa</th>
                        <th>Vrsta mleka</th>
                        <th v-if="user.tip === 'tehnolog'" class="rounded-tr-xl pr-2">Količina mleka</th>
                        <th v-if="user.tip === 'rukovodilac'" class="rounded-tr-xl pr-2">Primljeno</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="nalog in radni_nalozi" class="even:bg-neutral-900/90 odd:bg-neutral-900/50 border-t-1">
                        <td v-text="'#' + nalog.id" class="pl-2 py-2.5"></td>
                        <td>
                            <TextLink v-if="user.tip === 'vozac' || user.tip === 'tehnolog'" :href="route('radni-nalog.edit', nalog)">Obradi nalog</TextLink>
                            <TextLink v-if="user.tip === 'rukovodilac'" :href="route('radni-nalog.show', nalog)">Pregledaj nalog</TextLink>
                        </td>
                        <td v-text="nalog.domacinstvo.naziv"></td>
                        <td v-if="user.tip === 'vozac'" v-text="nalog.domacinstvo.adresa"></td>
                        <td v-text="nalog.tip_mleka"></td>
                        <td v-if="user.tip === 'tehnolog'" v-text="nalog.kolicina_mleka ? nalog.kolicina_mleka + ' L' : '-'"></td>
                        <td v-if="user.tip === 'rukovodilac'">
                            <p v-text="nalog.primljeno ? 'Da' : 'Ne'" class="inline-flex px-2 rounded-full border-2 font-semibold" :class="[nalog.primljeno ? 'bg-green-600 border-green-400' : 'bg-red-600 border-red-400']"></p>
                        </td>
                    </tr>
                    <tr class="bg-neutral-800/80">
                        <td colspan="5" class="text-sm rounded-b-xl py-1.5 px-2 text-center">
                            <p>Ukupno: {{ radni_nalozi.length }}</p>
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
        radni_nalozi: Object,
    },
};
</script>