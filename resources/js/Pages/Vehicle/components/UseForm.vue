<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import UseUploadFiles from "./UseUploadFiles.vue";
import AutoComplete from "primevue/autocomplete";
import ProgressBar from "@/Components/ProgressBar.vue";
import { onMounted } from "vue";
import { useGalleryStore } from "@/Store/gallery";
import {
    // form,
    // getModels,
    // saveVehicle,
    // filterModels,
    // searchModels,
    // searchColor,
    // allColors,
} from "../modules/create";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});

const submitVehicle = () => {
    form.gallery = useGalleryStore().getImages();
    form.color_id = form.color_id?.id || "";
    form.model_id = form.model_id?.id || "";
    saveVehicle();
};

onMounted(() => {
    form.gallery = useGalleryStore().getImages();
});
</script>
<template>
    <form @submit.prevent="submitVehicle">
        <div class="flex flex-col gap-5">
            <div>
                <InputLabel for="chassis" value="Nº de Chasis" />
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
            </div>

            <div>
                <div class="flex justify-start gap-3">
                    <InputLabel for="brand" value="Marca" />
                    <!-- <button
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-light text-xs text-white uppercase tracking-wide hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        type="button"
                        @click.stop="showModalBrand = true"
                    >
                        <i class="fas fa-plus"></i>
                        Nueva marca
                    </button> -->
                    <!-- <UseCreateBrandModal
                        :show="showModalBrand"
                        @close="showModalBrand = false"
                    /> -->
                </div>

                <!-- radio button -->
                <div class="mt-2 flex gap-5">
                    <div v-for="brand in brands" :key="brand.id">
                        <div
                            class="flex items-center gap-1 border-2 rounded-lg p-1 md:p-3"
                        >
                            <input
                                type="radio"
                                name="brand"
                                :id="brand.name"
                                :value="brand.id"
                                v-model="form.brand_id"
                                @change="getModels(models)"
                                class="mt-1 text-turquesa border border-turquesa focus:ring-turquesa focus:ring-2 w-5 h-5"
                            />
                            <label
                                :for="brand.name"
                                class="hover:cursor-pointer"
                                >{{ brand.name }}</label
                            >
                        </div>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.brand_id" />
            </div>

            <div>
                <div class="flex justify-start gap-3">
                    <InputLabel for="model" value="Modelo" />
                    <!-- <button
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-light text-xs text-white uppercase tracking-wide hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        type="button"
                        @click.stop="showModalModel = true"
                    >
                        <i class="fas fa-plus"></i>
                        Nuevo modelo
                    </button>
                    <UseCreateModelModal
                        :show="showModalModel"
                        :brands="brands"
                        @close="showModalModel = false"
                    /> -->
                </div>
                <AutoComplete
                    v-model="form.model_id"
                    :suggestions="filterModels"
                    field="name"
                    dropdown
                    forceSelection
                    @complete="searchModels($event, models)"
                />
                <InputError class="mt-2" :message="form.errors.model_id" />
            </div>

            <div>
                <div class="flex justify-start gap-3">
                    <InputLabel for="color" value="Color" />
                    <!-- <button
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-light text-xs text-white uppercase tracking-wide hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        type="button"
                        @click.stop="showModalColor = true"
                    >
                        <i class="fas fa-plus"></i>
                        Nuevo color
                    </button>
                    <UseCreateColorModal
                        :show="showModalColor"
                        @close="showModalColor = false"
                    /> -->
                </div>
                <AutoComplete
                    v-model="form.color_id"
                    field="name"
                    dropdown
                    :suggestions="allColors"
                    @complete="searchColor($event, colors)"
                />
                <InputError class="mt-2" :message="form.errors.color_id" />
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
