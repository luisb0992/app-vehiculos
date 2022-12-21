<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import {
    clearForm,
    handleUpdateWorkshop
} from "../modules/edit";

const props = defineProps({
    workshop: Object,
});

const form = useForm({
    name: props.workshop.name,
});

</script>
<template>
    <form @submit.prevent="handleUpdateWorkshop(form,props.workshop.id)">
        <div class="flex flex-col gap-5">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.name"
                    required
                    autofocus
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.name"
                />
            </div>

            <div class="flex flex-col md:lg:flex-row gap-2">
                <PrimaryButton
                    class="w-full  flex justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    :type="form.processing ? 'button' : 'submit'"
                >
                    <span class="px-6 py-3 uppercase"> Guardar </span>
                </PrimaryButton>
                <SecondaryButton @click="clearForm(form)" class="w-full  flex justify-center">
                     <span class="px-6 py-3 uppercase"> Limpiar </span>
                </SecondaryButton>
            </div>
        </div>
    </form>
</template>
