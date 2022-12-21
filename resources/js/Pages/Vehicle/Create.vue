<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import UseForm from "./components/UseForm.vue";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});
</script>
<template>
    <Head title="Nuevo reporte vehicular" />

    <Layout>
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white py-7 px-5 rounded-md">
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
