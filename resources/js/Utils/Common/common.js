/**
 * Funcionalidades/util js comunes a todos los componentes
 */

import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

// año en curso
export const currentYear = new Date().getFullYear();

// verificar si hay cámaras disponibles
export const hasCamera = computed(() => {
    const nav =
        navigator &&
        navigator.mediaDevices &&
        navigator.mediaDevices.getUserMedia;

    return nav ? true : false;
});

// path públicos
export const pp = {
    resizeImgVehicle: computed(
        () => usePage().props?.value?.path?.vehicle?.resize
    ),
    originalImgVehicle: computed(
        () => usePage().props?.value?.path?.vehicle?.original
    ),
};
