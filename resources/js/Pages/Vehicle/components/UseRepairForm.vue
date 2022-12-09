<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import {
    form,
    saveRepair,
    addOrRemoveToArray,
    hasSubcategory,
    continueRepair,
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
                                                    'dock'
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
                                                    'warranty'
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
            <div class="pb-5 animate-fade-in-down flex flex-col gap-3" v-show="continueRepair">
                <div>
                    <InputLabel for="warranty" value="Garantía" />
                    <TextInput
                        id="warranty"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.warranty"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.warranty" />
                </div>
                <div>
                    <InputLabel for="bills" value="Gastos" />
                    <TextInput
                        id="bills"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.bills"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.bills" />
                </div>
                <div>
                    <InputLabel for="dock" value="Muelle" />
                    <TextInput
                        id="dock"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.dock"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.dock" />
                </div>
                <div>
                    <InputLabel for="workshop_id" value="Seleccionar taller" />
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
                <div>
                    <InputLabel for="send_date" value="Fecha envío" />
                    <TextInput
                        id="send_date"
                        type="text"
                        class="mt-1 block w-full border-gray-200 border"
                        v-model="form.send_date"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.send_date" />
                </div>
            </div>

            <!-- botonera -->
            <div>
                <PrimaryButton
                    class="w-full md:w-1/2 flex justify-center"
                    :disabled="!hasSubcategory"
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
                    :disabled="form.processing"
                    :type="form.processing ? 'button' : 'submit'"
                    v-if="continueRepair"
                >
                    <span class="px-6 py-3 uppercase"> Enviar al taller </span>
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
