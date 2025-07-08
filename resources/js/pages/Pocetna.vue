<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Početna',
        href: '/pocetna',
    },
];
</script>

<template>
    <Head title="Početna" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
            <Heading title="Zdravo!" description="Dobrodošli na sajt sistema prijema mleka u našoj mlekari." />
            <p>Da biste započeli saradnju sa nama, potrebno je da unesete podatke o svom domaćinstvu <TextLink :href="route('domacinstvo.create')">ovde</TextLink>.</p>
        </div>
    </AppLayout>
</template>
