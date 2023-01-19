<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import UseFormApi from "./components/UseFormApi.vue";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
});
</script>
<template>
    <Head title="Nuevo reporte vehicular" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 border-2 border-turquesa rounded-lg">
                    <div class="w-full pb-5">
                        <div
                            class="overflow-hidden shadow-sm sm:rounded-lg flex justify-between"
                        >
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Datos del vehículo
                            </h3>
                            <Link
                                :href="route('vehicle.index')"
                                class="bg-gray-800 hover:bg-gray-900 py-2 px-3 text-white rounded"
                            >
                                <span class="uppercase font-medium text-xs hidden md:block">
                                    Listado de Vehiculos
                                </span>
                                <span class="block md:hidden"> Listado </span>
                            </Link>
                        </div>
                    </div>
                    <div class="w-full">
                        <UseFormApi
                            :brands="brands"
                            :models="models"
                            :colors="colors"
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
