<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import UseUploadFiles from "./UseUploadFiles.vue";
import AutoComplete from "primevue/autocomplete";
import ProgressBar from "@/Components/ProgressBar.vue";
import Swal from 'sweetalert2'
import { onMounted,ref } from "vue";
import { useGalleryStore } from "@/Store/gallery";
import {
    form,
    getModels,
    saveVehicle,
    filterModels,
    searchModels,
    searchColor,
    allColors,
} from "../modules/create";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});

const loading = ref(false);


const submitVehicle = () => { //te deje un dd en el controlador para que veas que llega
    form.gallery = useGalleryStore().getImages();
    /* form.color_id = form.color_id?.id || "";
    form.model_id = form.model_id?.id || ""; */
    saveVehicle();
};

onMounted(() => {
    form.gallery = useGalleryStore().getImages();
});

const clearForm = () => {
    form.reset("chassis_number", "");
    form.reset("brand_id", "");
    form.reset("compania", "");
    form.reset("model_id", "");
    form.reset("color_id", "");
    form.reset("gallery", []);
};

const swalWithBootstrapButtons = Swal.mixin({
    buttonsStyling: true
})

//get api vehicle
const handleSearchVehicle = () => {
    loading.value = true;
    axios.post(import.meta.env.VITE_API_URL_TEST+import.meta.env.VITE_API_BASE_URL_TEST, { chasis: form.chassis_number })
    .then((response) => {
        const data = response.data.data; //response
        const status = response.data.data.vehiculo.status //status del vehiculo

        if(status == 'ERROR'){ // este status ERROR lo hice yo, no viene en la api. Este status es cuando nos e consigue el vehiculo
            swalWithBootstrapButtons.fire({
                title: 'Error!',
                text: 'No se encontro el vehiculo',
                icon: 'error',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    clearForm();
                }
            })
            loading.value = false;
            return;
        }
         form.color_id = data.vehiculo.auto.color;
         form.model_id = data.vehiculo.auto.modelo;
         form.brand_id = data.vehiculo.auto.marca;
         form.compania = data.vehiculo.auto.compania;

        loading.value = false;
    });

}
</script>
<template>
    <form @submit.prevent="submitVehicle">
        <div class="flex flex-col gap-5">
            <InputLabel for="chassis" value="Nº de Chasis" />
            <div class="flex flex-col md:lg:flex-row gap-3">
                <TextInput
                    id="chassis"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.chassis_number"
                    required
                    autofocus
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.chassis_number"
                />
                <Button :disabled="loading" type="button" @click.stop="handleSearchVehicle" :class="{
                        'bg-gray-600': loading,
                        'bg-gray-800': !loading,
                    }" class="flex flex-col items-center justify-center hover:bg-gray-900 py-1 px-3 text-white rounded">
                    <svg v-if="loading" class="w-5 h-5 text-white animate-spin" fill="none"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="uppercase font-medium text-xs">
                        Buscar
                    </span>
                </Button>
            </div>

            <div class="grid grid-cols-1 md:lg:grid-cols-2 gap-2">
                <div>
                    <InputLabel
                    value="Compañia"
                    class="font-bold text-lg"
                    />
                    <TextInput
                        id="compania"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border bg-gray-300"
                        v-model="form.compania"
                        required
                        autofocus
                        readonly
                    />
                    <InputError class="mt-2" :message="form.errors.compania" />
                </div>
                <div>
                    <InputLabel
                    value="Marca"
                    class="font-bold text-lg"
                    />
                    <TextInput
                        id="marca"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border bg-gray-300"
                        v-model="form.brand_id"
                        required
                        autofocus
                        readonly
                    />
                    <InputError class="mt-2" :message="form.errors.brand_id" />
                </div>
                <div>
                    <InputLabel
                    value="Modelo"
                    class="font-bold text-lg"
                    />
                    <TextInput
                        id="model"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border bg-gray-300"
                        v-model="form.model_id"
                        required
                        autofocus
                        readonly
                    />
                    <InputError class="mt-2" :message="form.errors.model_id" />
                </div>
                <div>
                    <InputLabel
                    value="Color"
                    class="font-bold text-lg"
                    />
                    <TextInput
                        id="color"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border bg-gray-300"
                        v-model="form.color_id"
                        required
                        autofocus
                        readonly
                    />
                    <InputError class="mt-2" :message="form.errors.color_id" />
                </div>
            </div>
            <div>
                <InputLabel
                    value="Tomar fotos o elegir imagenes del dispositivo"
                    class="font-bold text-lg"
                />
                <div class="py-3">
                    <div class="flex gap-3 mb-3">
                        <!-- <button
                            type="button"
                            @click.stop="showCamera = true"
                            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                        >
                            Activar cámara
                        </button>
                        <span>-</span> -->
                        <!-- <button
                            type="button"
                            @click.stop="showCamera = false"
                            class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                        >
                            Subir archivos o activar
                        </button> -->
                    </div>
                    <!-- <UseTakePhoto v-if="showCamera" /> -->
                    <UseUploadFiles />
                </div>
                <InputError class="mt-2" :message="form.errors.gallery" />
            </div>

            <ProgressBar :form="form" />

            <div>
                <PrimaryButton
                    class="w-full md:w-1/2 flex justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    :type="form.processing ? 'button' : 'submit'"
                >
                    <span class="px-6 py-3 uppercase"> Guardar </span>
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
