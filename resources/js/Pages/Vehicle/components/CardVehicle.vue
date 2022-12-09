<script setup>
import { pp } from "@/Utils/Common/common";
import { computed } from "vue";

const props = defineProps({
    vehicle: Object,
});

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
</script>
<template>
    <div class="flex flex-wrap items-start">
        <div class="w-full md:w-[30%] mb-3">
            <img
                :src="imgFullPath"
                class="w-full h-full object-cover object-center"
            />
        </div>
        <div class="w-full md:w-[70%]">
            <div class="flex flex-wrap justify-start md:px-4">
                <div class="w-full pb-2">
                    <label class="text-zinc-800 font-bold"> Nº chasis</label>
                    <p class="bg-zinc-200 p-3 rounded text-sm">
                        {{ vehicle.chassis_number }}
                    </p>
                </div>
                <div class="w-4/12 pr-3">
                    <label class="text-zinc-800 font-bold"> Marca </label>
                    <p class="bg-zinc-200 p-3 rounded text-sm">
                        {{ brand }}
                    </p>
                </div>
                <div class="w-4/12 pr-3">
                    <label class="text-zinc-800 font-bold"> Modelo </label>
                    <p class="bg-zinc-200 p-3 rounded text-sm">
                        {{ model }}
                    </p>
                </div>
                <div class="w-4/12">
                    <label class="text-zinc-800 font-bold"> Color </label>
                    <p class="bg-zinc-200 p-3 rounded text-sm">
                        {{ color }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
