<script setup>
import Layout from "@/Layouts/Layout.vue";
import CardVehicle from "../Vehicle/components/CardVehicle.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { numberToDecimal } from "@/Utils/Common/common";
import {
    saveQuote,
    form,
    taxString,
    subtotal,
    total,
    hasZero,
} from "./modules/create-quote";

const props = defineProps({
    order: Object,
});

// order_id
form.repair_order_id = props.order.id;

// inyecta cost
props.order.subcategories.forEach((sub) => {
    form.subs.push({
        id: sub.id,
        name: sub.name,
        cost: "",
    });
});

// const startFromBeginning = (e) => {
//     // form.subs.forEach((sub) => {
//     //     sub.cost = 0;
//     // });

//     // ubicar el puntero al principio del input
//     e.target.selectionStart = 0;
//     e.target.value = "";

//     // eliminar el valor del input
//     // e.target.value = "";
// };

// const hasValue = (e) => {
//     console.log(e);
//     // verifica si hay valor y agrega los decimales
//     if (e.target.value === "") {
//         return 0;
//     }

//     return 2;
// };

/**
 * Funcion que valida el formato del input
 * max 2 decimales y que no se pueda ingresar letras
 * ejemplo: 1.200,99
 *
 * @param {Input} e     Input del usuario
 */
const validateFormat = (e) => {
    const val = e.target.value;

    // permitir max 2 decimales por regex
    const regex = /^(\d{1,9}(\.\d{1,2})?|\.\d{1,2})$/;
    if (!regex.test(val)) {
        e.target.value = val.slice(0, -1);
    }

    // verifica si hay valor y agrega los decimales
    if (val === "") {
        return 0;
    }

    // verifica si el valor es un numero
    if (isNaN(val)) {
        val = val.slice(0, -1);
    }
};
</script>
<template>
    <Head title="Cotización de vehículo" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 border-2 border-turquesa rounded-lg">
                    <div class="w-full pb-5">
                        <div class="flex justify-between items-center">
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Cotización
                            </h3>
                            <Link
                                :href="route('workshop_quotes.index')"
                                class="hover:no-underline bg-gray-700 px-3 py-2 hover:bg-gray-900 text-gray-50 rounded text-xs font-bold"
                            >
                                Listado cotizaciones
                            </Link>
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
                                            <input
                                                type="number"
                                                step="1,99"
                                                min="1"
                                                max="999999999"
                                                v-model="sub.cost"
                                                class="w-full border border-turquesa rounded-md shadow-sm focus:border-indigo-800 focus:ring focus:ring-indigo-800 focus:ring-opacity-50"
                                                @input="validateFormat"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div
                                class="flex flex-col justify-end py-5 border-t"
                            >
                                <div>
                                    <p
                                        class="text-right p-3 text-sm md:text-lg"
                                    >
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
                                    <p
                                        class="text-right p-3 text-sm md:text-lg"
                                    >
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
                                    <p
                                        class="text-right p-3 text-sm md:text-lg"
                                    >
                                        Total
                                        <span class="bg-gray-100 p-3 rounded">
                                            {{ total }}
                                        </span>

                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.total"
                                        />
                                    </p>
                                </div>
                            </div>

                            <ProgressBar
                                :form="form"
                                class="animate-fade-in-down mb-2"
                            />

                            <div class="flex justify-end">
                                <PrimaryButton
                                    type="button"
                                    class="px-7 py-4 text-lg uppercase"
                                    :class="{ 'opacity-50': hasZero }"
                                    :disabled="hasZero"
                                    @click.stop="saveQuote"
                                >
                                    Cotizar
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
