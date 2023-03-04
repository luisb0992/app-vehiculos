<script setup>
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
// import InputText from "primevue/inputtext";
// import { manageError } from "@/Utils/Common/common";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "3xl",
    },
    quotation_id: {
        type: Number,
        default: 0,
        description: "Id de la cotización realizada",
    },
    chassis_number: {
        type: String,
        default: "",
        description: "Número de chasis del vehiculo",
    },
});

// variables reactivas
const loading = ref(false);

// eventos
const emit = defineEmits(["close"]);

// formulario - datos
const form = useForm({
    quotation_id: "",
    invoice_number: "",
    invoice: "",
});

/**
 * validar y cargar la factura
 *
 * @param {*} e     evento
 */
const validateAndLoadInvoice = (e) => {
    const file = e.target.files[0];
    const allowedExtensions = /(\.pdf|\.txt|\.csv|\.docx|\.doc|\.xls|\.xlsx)$/i;

    if (!allowedExtensions.exec(file.name)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Solo se permiten archivos pdf, txt, csv, docx, doc, xls, xlsx",
        });

        // limpiar el input y el form
        e.target.value = "";
        form.reset("invoice", null);

        return;
    }

    form.invoice = file;
};

/**
 * Guardar la factura
 */
const saveInvoice = () => {
    loading.value = true;

    form.post(route("workshop_quotes.saveInvoice"), {
        onSuccess: () => {
            loading.value = false;
            clearForm();
            emit("close");
        },
        onError: () => {
            loading.value = false;
            manageError();
        },
    });
};

const clearForm = () => {
    form.reset("invoice_number", null);
    form.reset("invoice", null);
};

// cuando este activo la modal
watch(
    () => props.show,
    (value) => {
        if (value) {
            form.quotation_id = props.quotation_id;
        }
    }
);
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-gray-900 text-xl font-bold pb-3">
                    Facturación
                </h3>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-3 rounded-full  text-sm font-medium text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </div>
            <div class="w-full">
                <div class="py-5 flex flex-col gap-5">
                    <div class="">
                        <InputLabel
                            for="invoice_number"
                            value="Nº de chasis"
                            class="font-bold text-lg"
                        />
                        <span class="text-blue-900">
                            {{ props.chassis_number }}
                        </span>
                    </div>
                    <div class="">
                        <InputLabel
                            for="invoice_number"
                            value="Nº de factura"
                            class="font-bold text-lg"
                        />
                        <TextInput
                            id="invoice_number"
                            type="text"
                            class="mt-1 block w-full border-gray-200 border"
                            v-model="form.invoice_number"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.invoice_number"
                        />
                    </div>
                    <div class="">
                        <InputLabel
                            for="invoice"
                            value="Cargar factura"
                            class="font-bold text-lg"
                        />
                        <label class="block border rounded">
                            <span class="sr-only"> Cargar factura </span>
                            <input
                                type="file"
                                @change="validateAndLoadInvoice($event)"
                                id="invoice"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-300"
                                required
                            />
                        </label>
                        <InputError
                            class="mt-2"
                            :message="form.errors.invoice"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-5 gap-3">
                <PrimaryButton
                    @click.stop="saveInvoice"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                >
                    Guardar datos
                </PrimaryButton>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    Cerrar
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
