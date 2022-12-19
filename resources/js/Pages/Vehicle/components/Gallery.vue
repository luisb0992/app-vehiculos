<script setup>
import { pp } from "@/Utils/Common/common";

const props = defineProps({
    images: Array,
});

const getPath = (path) => {
    return pp.resizeImgVehicle.value + path;
};
</script>
<template>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-5 md:py-2">
        <div class="w-full" v-for="image in images" :key="image.id">
            <img
                :src="getPath(image.path)"
                class="w-full h-full object-cover object-center aspect-video rounded"
            />
        </div>
    </div>
</template>
