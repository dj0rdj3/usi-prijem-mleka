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
            <div class="flex flex-wrap items-start gap-5">
                <div v-for="nalog in radni_nalozi" class="bg-neutral-900 p-3 rounded-xl border border-neutral-800">
                    <h4 class="font-semibold">Radni nalog #{{ nalog.id }}</h4>
                    <hr />

                    <p>
                        <span class="text-sm font-semibold">Domaćinstvo:</span><br />
                        {{ nalog.domacinstvo.naziv }}<br />
                        <span v-if="user.tip === 'vozac'" class="text-sm">{{ nalog.domacinstvo.adresa }}</span>
                    </p>
                    <hr />

                    <p v-if="user.tip === 'tehnolog'">
                        <span class="text-sm font-semibold">Količina:</span><br />
                        {{ nalog.kolicina_mleka }}&nbsp;L<br />
                    </p>
                    <hr v-if="user.tip === 'tehnolog'" />

                    <p>
                        <span class="text-sm font-semibold">Tip mleka:</span><br />
                        {{ nalog.tip_mleka }}
                    </p>

                    <Button class="mt-2">
                        <TextLink nostyle :href="route('radni-nalog.edit', nalog)">Obradi nalog</TextLink>
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Heading from '@/components/Heading.vue'
import { Button } from '@/components/ui/button'
export default {
    props: {
        radni_nalozi: Object,
    },
};
</script>