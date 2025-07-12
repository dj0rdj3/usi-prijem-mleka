<script setup>
import Icon from '@/components/Icon.vue'
import TextLink from '@/components/TextLink.vue'
</script>

<template>
    <TextLink nostyle :href="href" class="bg-neutral-800 hover:bg-neutral-700 rounded-xl border border-neutral-700 px-4 py-2.5 font-semibold w-64">
        <Icon :name="icon" class="size-12 mb-1.5" />
        <p>
            <slot />
        </p>
    </TextLink>
</template>

<script>
export default {
    props: {
        icon: String,
        href: String,
    },
};
</script>