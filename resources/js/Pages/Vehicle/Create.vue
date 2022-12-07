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
</script>
<template>
    <Head title="Nuevo reporte vehicular" />

    <Layout>
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
                    <UseForm
                        :brands="brands"
                        :models="models"
                        :colors="colors"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>
