<template>
    <div class="self-center bg-neutral-800 rounded-xl border border-neutral-700 text-center px-3 py-2">
        <div class="flex gap-3 mb-1.5">
            <div class="flex justify-between gap-3" v-for="stat, i in stats">
                <p>
                    <span class="font-thin text-sm" v-text="stat.title"></span><br />
                    <span class="text-4xl tracking-wide font-bold" v-text="stat.value"></span>
                </p>
                <div v-if="i !== stats.length - 1" class="border-r-1 h-11/12 mt-1 border-neutral-700"></div>
            </div>
        </div>
        <p class="font-semibold text-sm" v-text="mainTitle"></p>
    </div>
</template>

<script>
export default {
    props: {
        mainTitle: String,
        stats: Array
    },
};
</script>