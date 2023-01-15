<script setup>
import { pp } from "@/Utils/Common/common";
import { computed, ref } from "vue";
import FullImageModal from "./FullImageModal.vue";

const props = defineProps({
    vehicle: Object,
    fullImages: {
        type: Boolean,
        default: true,
        description: "Mostrar todas las imagenes",
    },
});

// ref
const image = ref({});
const showModal = ref(false);

// path de la imagen del vehículo
// solo la primera imagen del vehículo
const imgFullPath = computed(
    () => pp.resizeImgVehicle.value + props.vehicle?.gallery[0]?.path
);

// filtro para marca del vehículo
// no mas de 10 caracteres
const brand = computed(() => {
    if (props.vehicle?.brand?.name.length > 10) {
        return props.vehicle?.brand?.name.substring(0, 10) + "...";
    }
    return props.vehicle?.brand?.name;
});

// filtro para modelo del vehículo
// no mas de 10 caracteres
const model = computed(() => {
    if (props.vehicle?.model?.name.length > 10) {
        return props.vehicle?.model?.name.substring(0, 10) + "...";
    }
    return props.vehicle?.model?.name;
});

// filtro para color del vehículo
// no mas de 10 caracteres
const color = computed(() => {
    if (props.vehicle?.color?.name.length > 10) {
        return props.vehicle?.color?.name.substring(0, 10) + "...";
    }
    return props.vehicle?.color?.name;
});

// devuelve el path de la imagen
// si no existe devuelve una imagen por defecto
const imgPath = (path) => {
    if (path) {
        return pp.resizeImgVehicle.value + path;
    }
    return "/";
};

// abrir la imagen pantalla completa
const openImage = (img = null) => {
    const firstImage = props.vehicle?.gallery[0];
    image.value = !img ? firstImage : img;
    showModal.value = true;
};
</script>
<template>
    <div class="flex flex-wrap items-start">
        <div class="w-full md:w-[30%] mb-3">
            <img
                :src="imgFullPath"
                class="w-full h-full object-cover object-center rounded aspect-video hover:cursor-pointer"
                @click.stop="openImage(null)"
            />
        </div>
        <div class="w-full md:w-[70%] mb-3">
            <div class="flex flex-wrap justify-start md:px-4">
                <div class="w-full pb-2">
                    <label class="text-zinc-800 font-bold"> Nº chasis</label>
                    <p class="bg-zinc-200 p-2 rounded text-sm">
                        {{ vehicle.chassis_number }}
                    </p>
                </div>
                <div class="w-4/12 pr-3">
                    <label class="text-zinc-800 font-bold"> Marca </label>
                    <p class="bg-zinc-200 p-2 rounded text-sm">
                        {{ brand }}
                    </p>
                </div>
                <div class="w-4/12 pr-3">
                    <label class="text-zinc-800 font-bold"> Modelo </label>
                    <p class="bg-zinc-200 p-2 rounded text-sm">
                        {{ model }}
                    </p>
                </div>
                <div class="w-4/12">
                    <label class="text-zinc-800 font-bold"> Color </label>
                    <p class="bg-zinc-200 p-2 rounded text-sm">
                        {{ color }}
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full" v-if="fullImages && vehicle.gallery.length > 1">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                <img
                    :src="imgPath(img.path)"
                    class="w-full h-full object-cover object-center rounded aspect-video hover:cursor-pointer"
                    v-for="img in vehicle.gallery"
                    @click.stop="openImage(img)"
                />
            </div>
        </div>
    </div>

    <FullImageModal
        max-width="5x1"
        :img="image"
        :show="showModal"
        @close="showModal = false"
    />
</template>
