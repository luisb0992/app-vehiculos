<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import UseRepairForm from "./components/UseRepairForm.vue";
import CardVehicle from "./components/CardVehicle.vue";
import { useGalleryStore } from "@/Store/gallery";
import { onMounted } from "vue";

const props = defineProps({
    vehicle: Object,
    categories: Array,
    workshops: Array,
});

onMounted(() => {
    useGalleryStore().clearImages();
    useGalleryStore().clearSessionStorage();
});
</script>
<template>
    <Head title="Solicitar reparación" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 rounded-lg border border-turquesa">
                    <div class="w-full pb-5">
                        <div
                            class="overflow-hidden shadow-sm sm:rounded-lg flex justify-between pb-3"
                        >
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Datos vehículo
                            </h3>
                            <Link
                                :href="route('vehicle.index')"
                                class="bg-gray-800 hover:bg-gray-900 py-2 px-3 text-white rounded"
                            >
                                <span class="uppercase font-medium text-xs hidden md:block">
                                    Listado de Vehiculos
                                </span>
                                <span class="block md:hidden"> Vehiculos </span>
                            </Link>
                        </div>
                    </div>
                    <div class="w-full">
                        <CardVehicle :vehicle="vehicle"/>
                    </div>
                    <div class="w-full py-5">
                        <UseRepairForm
                            :vehicle="vehicle"
                            :categories="categories"
                            :workshops="workshops"
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
