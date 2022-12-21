<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import CardVehicle from "../Vehicle/components/CardVehicle.vue";
import InputNumber from "primevue/inputNumber";
import { computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { numberToDecimal } from "@/Utils/Common/common";
import Gallery from "../Vehicle/components/Gallery.vue";
import {
    saveQuote,
    form,
    taxString,
    subtotal,
    total,
    hasZero,
} from "./modules/create-quote";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    order: Object,
});

const images = computed(() =>
    props.order.vehicle.gallery.filter((_, i) => i !== 0)
);

// order_id
form.repair_order_id = props.order.id;

// inyecta cost
props.order.subcategories.forEach((sub) => {
    form.subs.push({
        id: sub.id,
        name: sub.name,
        cost: 0,
    });
});
</script>
<template>
    <Head title="Cotización de vehículo" />

    <Layout>
        <div class="mx-auto sm:px-6 lg:px-8">
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
                        <Gallery :images="images" />
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

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.subtotal"
                                    />
                                </p>
                            </div>
                            <div>
                                <p class="text-right p-3 text-sm md:text-lg">
                                    Impuesto
                                    <span class="bg-gray-100 p-3 rounded">
                                        {{ taxString }}
                                    </span>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.tax"
                                    />
                                </p>
                            </div>
                            <div>
                                <p class="text-right p-3 text-sm md:text-lg">
                                    Total
                                    <span class="bg-gray-100 p-3 rounded">
                                        {{ numberToDecimal(total) }}
                                    </span>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.total"
                                    />
                                </p>
                            </div>
                        </div>

                        <div class="w-full">
                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                                class="w-full"
                            >
                                {{ form.progress.percentage }}%
                            </progress>
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton
                                type="button"
                                class="px-7 py-4 text-lg uppercase"
                                :class="{
                                    'opacity-50': hasZero,
                                }"
                                @click.stop="saveQuote"
                                :disabled="hasZero"
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
