<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { currentDate } from "@/Utils/Common/common";
import {
    form,
    saveRepair,
    addOrRemoveToArray,
    hasSubcategory,
    continueRepair,
    warrantySubcategories,
    dockSubcategories,
    canSendWorkshop,
    addOrRemoveOption,
    loadOrder,
    canCreateOrder,
    getWorkshopName,
    hasSubToAssign,
} from "../modules/repair";

const props = defineProps({
    vehicle: Object,
    categories: Array,
    workshops: Array,
});
</script>
<template>
    <div class="border-b border-gray-200 pb-3 mb-5">
        <h3 class="text-gray-900 text-2xl font-bold">Solicitar reparación</h3>
    </div>
    <form @submit.prevent="saveRepair">
        <div class="flex flex-col gap-5">
            <!-- primera parte -->
            <div class="pb-5 animate-fade-in-down" v-show="!continueRepair">
                <div class="mx-auto w-full drop-shadow rounded-md">
                    <details
                        class="bg-gray-200 open:bg-gray-800 open:text-gray-50 duration-300"
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <summary
                            class="bg-inherit px-5 py-3 text-lg cursor-pointer"
                        >
                            {{ category.name }}
                        </summary>
                        <div
                            class="bg-white px-2 py-3 border border-gray-300 text-sm font-light"
                        >
                            <div class="flex flex-row justify-end">
                                <div class="text-zinc-800">Muelle /&nbsp;</div>
                                <div class="text-zinc-800">Garantía</div>
                            </div>
                            <div v-for="sub in category.repair_subcategories">
                                <div class="flex flex-row justify-between py-1">
                                    <div>
                                        <label
                                            class="form-check-label inline-block text-zinc-900 text-xs"
                                        >
                                            {{ sub.name }}
                                        </label>
                                    </div>
                                    <div>
                                        <input
                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                            type="checkbox"
                                            @change="
                                                addOrRemoveToArray(
                                                    $event,
                                                    category.id,
                                                    sub.id,
                                                    'dock',
                                                    sub.name
                                                )
                                            "
                                            :id="'dock' + sub.id"
                                        />
                                        <input
                                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                            type="checkbox"
                                            @change="
                                                addOrRemoveToArray(
                                                    $event,
                                                    category.id,
                                                    sub.id,
                                                    'warranty',
                                                    sub.name
                                                )
                                            "
                                            :id="'warranty' + sub.id"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </details>
                </div>
            </div>

            <!-- segunda parte -->
            <div
                class="pb-5 animate-fade-in-down flex flex-col gap-3"
                v-show="continueRepair"
            >
                <div class="border border-green-800 p-2 rounded">
                    <InputLabel
                        for="warranty"
                        value="Garantías seleccionadas"
                        class="font-bold text-green-800"
                    />
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="warranty in warrantySubcategories"
                            :key="warranty.sub_id"
                        >
                            <div class="flex flex-row justify-between py-1">
                                <div>
                                    <label
                                        class="inline-block text-zinc-900 text-xs cursor-pointer"
                                        :for="
                                            'selectedWarranty' + warranty.sub_id
                                        "
                                    >
                                        {{ warranty.sub_name }}
                                    </label>
                                </div>
                                <div>
                                    <input
                                        class="appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white focus:bg-green-800 hover:bg-green-800 checked:bg-green-800 checked:border-green-800 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        type="checkbox"
                                        :id="
                                            'selectedWarranty' + warranty.sub_id
                                        "
                                        @change="
                                            addOrRemoveOption(
                                                $event,
                                                warranty.sub_id,
                                                warranty.sub_name,
                                                'warranty'
                                            )
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="form.errors.selectedWarranty"
                    />
                </div>
                <div class="border border-blue-800 p-2 rounded">
                    <InputLabel
                        for="dock"
                        value="Muelles seleccionados"
                        class="font-bold text-blue-800"
                    />
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="dock in dockSubcategories"
                            :key="dock.sub_id"
                        >
                            <div class="flex flex-row justify-between py-1">
                                <div>
                                    <label
                                        class="inline-block text-zinc-900 text-xs cursor-pointer"
                                        :for="'selectedDock' + dock.sub_id"
                                    >
                                        {{ dock.sub_name }}
                                    </label>
                                </div>
                                <div>
                                    <input
                                        class="appearance-none h-4 w-4 border border-gray-400 rounded-sm bg-white checked:bg-blue-800 checked:border-blue-800 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                        type="checkbox"
                                        :id="'selectedDock' + dock.sub_id"
                                        @change="
                                            addOrRemoveOption(
                                                $event,
                                                dock.sub_id,
                                                dock.sub_name,
                                                'dock'
                                            )
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.dock" />
                </div>
                <div v-if="canSendWorkshop">
                    <InputLabel
                        for="workshop_id"
                        value="Seleccionar taller"
                        class="font-bold"
                    />
                    <select
                        id="workshop_id"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.workshop_id"
                        required
                    >
                        <option value="">Seleccione una taller..</option>
                        <option
                            v-for="shop in workshops"
                            :key="shop.id"
                            :value="shop.id"
                        >
                            {{ shop.name }}
                        </option>
                    </select>
                    <InputError
                        class="mt-2"
                        :message="form.errors.workshop_id"
                    />
                </div>
                <div v-if="canSendWorkshop">
                    <InputLabel
                        for="send_date"
                        value="Fecha envío"
                        class="font-bold"
                    />
                    <TextInput
                        id="send_date"
                        type="date"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.send_date"
                        required
                        :min="currentDate"
                    />
                    <InputError class="mt-2" :message="form.errors.send_date" />
                </div>
                <div v-if="canSendWorkshop">
                    <button
                        type="button"
                        @click.stop="loadOrder"
                        class="px-3 py-2 bg-green-800 hover:bg-green-900 animate-shadow-drop-center rounded text-white uppercase text-xs font-light"
                        :disabled="!canCreateOrder"
                    >
                        Enviar al taller
                    </button>
                </div>
                <div v-if="form.orders.length">
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="order in form.orders"
                            :key="order.id"
                            class="border border-gray-200 p-2 rounded"
                        >
                            <div class="flex flex-col justify-between">
                                <div>
                                    <span class="font-bold text-gray-800">
                                        {{
                                            getWorkshopName(
                                                workshops,
                                                order.workshop_id
                                            )
                                        }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-800">
                                        {{ order.send_date }}
                                    </span>
                                </div>
                                <div class="border border-gray-200 p-1">
                                    <p
                                        class="font-bold text-gray-800"
                                        v-for="sub in order.subs"
                                        :key="sub.sub_id"
                                    >
                                        {{ sub.sub_name }}
                                    </p>
                                </div>
                                <div>
                                    <button
                                        type="button"
                                        class="px-3 py-2 bg-red-800 hover:bg-red-900 animate-shadow-drop-center rounded text-white uppercase text-xs font-light"
                                    >
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- botonera -->
            <div class="py-5">
                <PrimaryButton
                    class="w-full md:w-1/2 flex justify-center"
                    @click.stop="continueRepair = true"
                    v-if="!continueRepair"
                >
                    <span class="px-6 py-3 uppercase"> Continuar </span>
                </PrimaryButton>

                <PrimaryButton
                    class="w-full md:w-1/2 flex justify-center mb-3"
                    type="button"
                    v-if="continueRepair"
                    @click.stop="continueRepair = false"
                >
                    <span class="px-6 py-3 uppercase"> Volver a opciones </span>
                </PrimaryButton>
                <PrimaryButton
                    class="w-full md:w-1/2 flex justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="
                        form.processing || hasSubToAssign || !form.orders.length
                    "
                    :type="form.processing ? 'button' : 'submit'"
                    v-if="continueRepair"
                >
                    <span class="px-6 py-3 uppercase"> FInalizar caso </span>
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
