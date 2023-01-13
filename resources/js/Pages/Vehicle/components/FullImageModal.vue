<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { pp } from "@/Utils/Common/common";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "5xl",
    },
    img: {
        type: Object,
        default: {},
    },
});

const imgPath = (path) => {
    if (path) {
        return pp.resizeImgVehicle.value + path;
    }
    return "/";
};
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
            <div class="w-full h-full">
                <img
                    :src="imgPath(img.path)"
                    class="w-full h-full object-cover object-center rounded aspect-video"
                />
            </div>
            <div class="flex justify-center pt-5">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-900 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-900 transition ease-in-out duration-150"
                >
                    aceptar
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
