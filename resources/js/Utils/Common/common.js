/**
 * Funcionalidades/util js comunes a todos los componentes
 */

import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

// año en curso
export const currentYear = new Date().getFullYear();

// devolver la fecha actual en formato mm/dd/yyyy
export const currentDate = computed(() => {
    const date = new Date();
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${year}-${month}-${day}`;
});

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
    resizeImgVehicle: computed(() => usePage().props.value.path.vehicle.resize),
    originalImgVehicle: computed(
        () => usePage().props.value.path.vehicle.original
    ),
};

