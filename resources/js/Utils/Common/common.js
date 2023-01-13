/**
 * Funcionalidades/util js comunes a todos los componentes
 */

import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";
import Swal from "sweetalert2";

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

// devolver el valor en el formato 1.000,00
// formato europeo
export const numberToDecimal = (value) => {
    return new Intl.NumberFormat("de-DE").format(value);
};

/**
 * Muestra mensajes de error o de aviso de la app
 *
 * @param {Object} params   Objeto con los parámetros de la alerta
 * @returns            Objeto con la alerta de sweetalert2
 */
export const manageError = ({
    icon = "error",
    title = "Aviso!",
    text = "Ha ocurrido un error inesperado, intente mas tarde",
}) => {
    return Swal.fire({ icon, title, text });
};
