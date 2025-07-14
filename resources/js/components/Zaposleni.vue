<script setup>
import { LoaderCircle } from 'lucide-vue-next'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import Select from '@/components/Select.vue'
</script>

<template>
    <td v-text="zaposleni.name" class="pl-2"></td>
    <td v-text="zaposleni.telefon"></td>
    <td>
        <form>
            <Select v-model="formPozicija.tip" @update:model-value="submitPozicija" :options="zaposleni_tipovi" class="my-1.5 mr-3 max-w-40" />
            <InputError :message="formPozicija.errors.tip" />
        </form>
    </td>
    <td>
        <form @submit.prevent="submitDelete" v-if="zaposleni.tip !== 'domacin'">
            <Button type="submit" variant="destructive" :disabled="formDelete.processing" class="my-1.5 mx-2">
                <LoaderCircle v-if="formDelete.processing" class="h-4 w-4 animate-spin" />
                Otpusti
            </Button>
        </form>
    </td>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
export default {
    props: {
        zaposleni: Object
    },
    data() {
        return {
            zaposleni_tipovi: {
                domacin: 'Domaćin',
                vozac: 'Vozač',
                tehnolog: 'Tehnolog',
            },
            formDelete: useForm(),
            formPozicija: useForm({
                tip: this.zaposleni.tip
            }),
        };
    },
    methods: {
        submitDelete() {
            this.formDelete.delete(route('zaposleni.destroy', this.zaposleni), {
                preserveState: true,
                preserveScroll: true,
                replace: true
            });
        },
        submitPozicija() {
            this.formPozicija.put(route('zaposleni.update', this.zaposleni), {
                preserveState: true,
                preserveScroll: true,
                replace: true
            });
        }
    },
};
</script>