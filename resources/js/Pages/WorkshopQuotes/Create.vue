<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import CardVehicle from "../Vehicle/components/CardVehicle.vue";
import InputNumber from "primevue/inputNumber";
import { computed, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { numberToDecimal } from "@/Utils/Common/common";

const props = defineProps({
    order: Object,
});

const form = useForm({
    subs: [],
    subtotal: 0,
    tax: 0,
    total: 0,
});

const tax = ref(7);
const taxString = computed(() => {
    return `${tax.value}%`;
});

const subtotal = computed(() => {
    return form.subs.reduce((acc, sub) => {
        return acc + sub.cost;
    }, 0);
});

const total = computed(() => {
    return subtotal.value + (subtotal.value * tax.value) / 100;
});

// crear prop cost por cada subcategoria
const createCost = () => {
    props.order.subcategories.forEach((sub) => {
        form.subs.push({
            id: sub.id,
            name: sub.name,
            cost: 0,
        });
    });
};

createCost();
</script>
<template>
    <Head title="Cotización de vehículo" />

    <Layout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white py-7 px-5 rounded-md">
                <div class="w-full pb-5">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Cotización
                        </h3>
                    </div>
                </div>
                <div class="w-full">
                    <div
                        class="bg-blue-800 text-white p-4 rounded text-center uppercase"
                    >
                        Nombre del taller:
                        <span class="font-bold">
                            {{ order.workshop.name }}
                        </span>
                    </div>
                    <div class="py-5">
                        <CardVehicle :vehicle="order.vehicle" />
                    </div>
                </div>
                <div class="w-full">
                    <div
                        class="bg-amber-600 text-white p-4 rounded text-center uppercase"
                    >
                        Cotización
                    </div>
                    <div class="py-5 w-full">
                        <table class="min-w-full">
                            <thead class="border-b">
                                <tr>
                                    <th class="text-center font-bold py-3">
                                        Items
                                    </th>
                                    <th class="text-center font-bold py-3">
                                        Costo
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sub in form.subs" :key="sub.id">
                                    <td
                                        class="text-center py-3 text-sm md:text-lg"
                                    >
                                        {{ sub.name }}
                                    </td>
                                    <td
                                        class="text-center py-3 text-sm md:text-lg"
                                    >
                                        <InputNumber
                                            :inputId="sub.name"
                                            mode="decimal"
                                            v-model.lazy="sub.cost"
                                            :minFractionDigits="2"
                                            :maxFractionDigits="2"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="flex flex-col justify-end py-5 border-t">
                            <div>
                                <p class="text-right p-3 text-sm md:text-lg">
                                    Subtotal
                                    <span class="bg-gray-100 p-3 rounded">
                                        {{ numberToDecimal(subtotal) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-right p-3 text-sm md:text-lg">
                                    Impuesto
                                    <span class="bg-gray-100 p-3 rounded">
                                        {{ taxString }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-right p-3 text-sm md:text-lg">
                                    Total
                                    <span class="bg-gray-100 p-3 rounded">
                                        {{ numberToDecimal(total) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton
                                type="button"
                                class="px-7 py-4 text-lg uppercase"
                            >
                                Cotizar
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
