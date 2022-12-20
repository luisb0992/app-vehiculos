<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { inject } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
});

// sweetalert2
const Swal = inject("$swal");

// emit
const emit = defineEmits(["close"]);

// form
const form = useForm({
    name: "",
});

// guardar la marca y cerrar modal
const saveBrand = () => {
    form.post(route("colors.vehicle.store"), {
        onError: (error) => console.log(error),
        onSuccess: () => {
            form.reset("name");
            emit("close");
            Swal({
                icon: "success",
                title: "Color creado",
                text: "El color se ha creado correctamente",
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        },
    });
};
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <form @submit.prevent="saveBrand">
            <div class="p-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Nuevo color para vehículo
                </h3>
                <hr class="pb-3 mt-2" />
                <div class="flex flex-col gap-5">
                    <div>
                        <InputLabel for="color" value="Color" />
                        <TextInput
                            id="color"
                            type="text"
                            class="mt-1 block w-full border-gray-200 border"
                            v-model="form.name"
                            required
                            autofocus
                            placeholder="Escriba un nombre para el color..."
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-5">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150"
                        type="button"
                        @click="$emit('close')"
                    >
                        Cancelar
                    </button>
                    <PrimaryButton
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-900 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900 transition ease-in-out duration-150"
                    >
                        Guardar
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
