<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { pp } from "@/Utils/Common/common";
import { computed, ref, onMounted } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "3xl",
    },
    vehicle: {
        type: Object,
        default: {},
    },
});

// variables reactivas
const loading = ref(false);

const emit = defineEmits(["close"]);
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
            <div class="flex justify-end pb-3">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </div>
            <div class="w-full">
                <div
                    class="flex flex-col md:flex-row md:justify-between items-center"
                >
                    <h3 class="uppercase text-zinc-900 font-bold pb-2">
                        Nº Chasis:
                        <span class="font-light">
                            {{ vehicle.chassis_number }}
                        </span>
                    </h3>
                    <p class="uppercase text-zinc-900 font-bold pb-2">
                        Imagenes:
                        <span class="font-light text-gray-900">
                            ({{ vehicle.gallery.length }})
                        </span>
                    </p>
                </div>
                <hr />
                <div class="w-full pt-2 h-[440px] overflow-y-auto">
                    <div class="flex flex-col gap-3">
                        <img
                            v-for="image in vehicle.gallery"
                            :src="`${pp.resizeImgVehicle.value + image.path}`"
                            class="w-full rounded"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-5">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                >
                    Cerrar
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
