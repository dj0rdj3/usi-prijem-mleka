<template>
    <div class="bg-neutral-800 rounded-xl border border-neutral-700 text-center px-4 py-2.5">
        <p>
            <span class="text-5xl tracking-wider font-bold" v-text="value"></span><br />
            <span class="font-semibold text-sm" v-text="title"></span>
        </p>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        value: String | Number,
    },
};
</script>