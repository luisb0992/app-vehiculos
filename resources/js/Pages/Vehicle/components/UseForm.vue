<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import UseTakePhoto from "./UseTakePhoto.vue";
import UseUploadFiles from "./UseUploadFiles.vue";
import UseCreateBrandModal from "./UseCreateBrandModal.vue";
import UseCreateModelModal from "./UseCreateModelModal.vue";
import UseCreateColorModal from "./UseCreateColorModal.vue";
import {
    form,
    getModels,
    saveVehicle,
    filterModels,
    showModalBrand,
    showModalModel,
    showModalColor,
    showCamera,
} from "../modules/create";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});
</script>
<template>
    <form @submit.prevent="saveVehicle">
        <div class="flex flex-col gap-5">
            <div>
                <InputLabel for="chassis" value="Chasis" />
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
                    <button
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-light text-xs text-white uppercase tracking-wide hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        type="button"
                        @click.stop="showModalBrand = true"
                    >
                        <i class="fas fa-plus"></i>
                        Nueva marca
                    </button>
                    <UseCreateBrandModal
                        :show="showModalBrand"
                        @close="showModalBrand = false"
                    />
                </div>
                <select
                    id="brand"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.brand_id"
                    required
                    @change="getModels(models)"
                >
                    <option value="">Seleccione una marca</option>
                    <option
                        v-for="brand in brands"
                        :key="brand.id"
                        :value="brand.id"
                    >
                        {{ brand.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.brand_id" />
            </div>

            <div>
                <div class="flex justify-start gap-3">
                    <InputLabel for="model" value="Modelo" />
                    <button
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
                    />
                </div>
                <select
                    id="model"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.model_id"
                    required
                >
                    <option value="">Seleccione un modelo</option>
                    <option
                        v-for="model in filterModels"
                        :key="model.id"
                        :value="model.id"
                    >
                        {{ model.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.model_id" />
            </div>

            <div>
                <div class="flex justify-start gap-3">
                    <InputLabel for="color" value="Color" />
                    <button
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
                    />
                </div>
                <select
                    id="color"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.color_id"
                    required
                >
                    <option value="">Seleccione un color</option>
                    <option
                        v-for="color in colors"
                        :key="color.id"
                        :value="color.id"
                    >
                        {{ color.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.color_id" />
            </div>

            <div>
                <InputLabel value="Tomar fotos" class="font-bold text-2xl" />
                <div class="py-3">
                    <div class="flex gap-3 mb-3">
                        <button
                            type="button"
                            @click.stop="showCamera = true"
                            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
                        >
                            Activar cámara
                        </button>
                        <span>-</span>
                        <button
                            type="button"
                            @click.stop="showCamera = false"
                            class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                        >
                            Subir archivos
                        </button>
                    </div>
                    <UseTakePhoto v-if="showCamera" />
                    <UseUploadFiles v-else />
                </div>
            </div>

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
