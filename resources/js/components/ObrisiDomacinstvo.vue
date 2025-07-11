<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps(['domacinstvo']);

const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const obrisiDomacinstvo = (e: Event) => {
    e.preventDefault();

    form.delete(route('domacinstvo.destroy', props.domacinstvo), {
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="destructive">Prekini saradnju</Button>
        </DialogTrigger>
        <DialogContent>
            <form class="space-y-6" @submit="obrisiDomacinstvo">
                <DialogHeader class="space-y-3">
                    <DialogTitle>Da li ste sigurni da želite da prekinete saradnju sa nama?</DialogTitle>
                    <DialogDescription>
                        Unesite svoju šifru ako želite da nastavite.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-2">
                    <Label for="password" class="sr-only">Šifra</Label>
                    <Input id="password" type="password" name="password" ref="passwordInput" v-model="form.password" placeholder="Šifra" />
                    <InputError :message="form.errors.password" />
                </div>

                <DialogFooter class="gap-2">
                    <DialogClose as-child>
                        <Button variant="secondary" @click="closeModal"> Odustani </Button>
                    </DialogClose>

                    <Button type="submit" variant="destructive" :disabled="form.processing"> Obriši domaćinstvo </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
