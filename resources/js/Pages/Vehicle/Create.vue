<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { currentYear } from "@/Utils/Common/common";
import { onMounted } from "vue";
import {
    form,
    getModels,
    saveVehicle,
    filterModels,
    clearForm,
} from "./modules/create";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});

// limpiar cuando se monte el componente
onMounted(() => {
    clearForm();
});
</script>
<template>
    <Head title="Nuevo reporte vehicular" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Datos del vehículo
                        </h3>
                    </div>
                </div>
                <div class="w-full">
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
                                <InputLabel for="brand" value="Marca" />
                                <select
                                    id="brand"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.brand_id"
                                    required
                                    @change="getModels(models)"
                                >
                                    <option value="">
                                        Seleccione una marca
                                    </option>
                                    <option
                                        v-for="brand in brands"
                                        :key="brand.id"
                                        :value="brand.id"
                                    >
                                        {{ brand.name }}
                                    </option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.brand_id"
                                />
                            </div>

                            <div>
                                <InputLabel for="model" value="Modelo" />
                                <select
                                    id="model"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.model_id"
                                    required
                                >
                                    <option value="">
                                        Seleccione un modelo
                                    </option>
                                    <option
                                        v-for="model in filterModels"
                                        :key="model.id"
                                        :value="model.id"
                                    >
                                        {{ model.name }}
                                    </option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.model_id"
                                />
                            </div>

                            <div>
                                <InputLabel for="color" value="Color" />
                                <select
                                    id="color"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.color_id"
                                    required
                                >
                                    <option value="">
                                        Seleccione un color
                                    </option>
                                    <option
                                        v-for="color in colors"
                                        :key="color.id"
                                        :value="color.id"
                                    >
                                        {{ color.name }}
                                    </option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.color_id"
                                />
                            </div>

                            <div>
                                <InputLabel for="year" value="Año" />
                                <TextInput
                                    id="year"
                                    type="number"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.year"
                                    step="1"
                                    :max="currentYear"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.year"
                                />
                            </div>

                            <div>
                                <InputLabel for="mileage" value="Kilometraje" />
                                <TextInput
                                    id="mileage"
                                    type="text"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.mileage"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.mileage"
                                />
                            </div>

                            <div>
                                <InputLabel for="price" value="Precio" />
                                <TextInput
                                    id="price"
                                    type="number"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.price"
                                    step="0.01"
                                    min="0"
                                    max="9999999999,99"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.price"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="description"
                                    value="Descripción"
                                />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.description"
                                ></textarea>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.description"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="observation"
                                    value="Alguna Observación"
                                />
                                <textarea
                                    id="observation"
                                    class="mt-1 block w-full border-gray-200 border"
                                    v-model="form.observation"
                                ></textarea>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.observation"
                                />
                            </div>

                            <div>
                                <PrimaryButton
                                    class="w-full md:w-1/2 flex justify-center"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    <span class="px-6 py-3 uppercase">
                                        Guardar
                                    </span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
