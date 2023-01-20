<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import UseUploadFiles from "./UseUploadFiles.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import { onMounted } from "vue";
import { useGalleryStore } from "@/Store/gallery";
import { form, saveVehicle, searchVehicle, loading } from "../modules/create";
import Spinner from "@/Components/Spinner.vue";

const submitVehicle = () => {
    form.gallery = useGalleryStore().getImages();
    saveVehicle();
};

onMounted(() => {
    form.gallery = useGalleryStore().getImages();
});
</script>
<template>
    <form @submit.prevent="submitVehicle">
        <div class="flex flex-col gap-5">
            <div class="flex justify-start gap-5 items-center -mb-4">
                <InputLabel
                    for="chassis"
                    value="Nº de Chasis"
                    class="font-bold text-lg"
                />
                <Spinner :show="loading" />
            </div>
            <div class="flex flex-col md:lg:flex-row gap-3">
                <TextInput
                    id="chassis"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.chassis_number"
                    required
                    autofocus
                />
                <!-- <InputError
                    class="mt-2"
                    :message="form.errors.chassis_number"
                /> -->
                <button
                    :disabled="loading || form.processing"
                    type="button"
                    @click.stop="searchVehicle"
                    :class="{ 'opacity-50': loading || form.processing }"
                    class="bg-red-600 hover:bg-red-800 transition-all duration-300 text-white font-bold py-2 px-4 rounded"
                >
                    <span class="uppercase text-xs"> Buscar </span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:lg:grid-cols-2 gap-2">
                <div>
                    <InputLabel value="Compañía" class="font-bold text-lg" />
                    <TextInput
                        id="company"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border bg-gray-300"
                        v-model="form.company"
                        required
                        autofocus
                        readonly
                    />
                    <InputError class="mt-2" :message="form.errors.company" />
                </div>
                <div>
                    <InputLabel value="Marca" class="font-bold text-lg" />
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
                    <InputLabel value="Modelo" class="font-bold text-lg" />
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
                    <InputLabel value="Color" class="font-bold text-lg" />
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
                    <div class="flex gap-3 mb-3"></div>
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
