<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Podešavanje izgleda',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Podešavanja izgleda" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Podešavanje izgleda" description="Promenite temu svoje aplikacije" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
