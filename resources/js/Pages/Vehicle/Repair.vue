<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import UseRepairForm from "./components/UseRepairForm.vue";
import CardVehicle from "./components/CardVehicle.vue";

const props = defineProps({
    vehicle: Object,
    categories: Array,
    workshops: Array,
});
</script>
<template>
    <Head title="Solicitar reparación" />

    <Layout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white py-7 px-5 rounded-md">
                <div class="w-full pb-5">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Datos del vehículo
                        </h3>
                    </div>
                </div>
                <div class="w-full">
                    <CardVehicle :vehicle="vehicle" />
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
    </Layout>
</template>
