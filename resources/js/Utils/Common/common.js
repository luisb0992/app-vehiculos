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

// fecha actual en formato mm/dd/yyyy
export const currentDateTime = computed(() => {
    const date = new Date();

    return date.toISOString().split("T")[0];
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

// devolver el valor en el formato 1,000.00
// formato dólar americanos
export const numberToDecimal = (value) => {
    return new Intl.NumberFormat("en-US", {
        currency: "USD",
    }).format(value);
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

// formatear una fecha dada a formato dd/mm/yyyy
export const formatDate = (date) => {
    const d = new Date(date);
    const day = d.getDate();
    const month = d.getMonth() + 1;
    const year = d.getFullYear();

    return `${day}/${month}/${year}`;
};

// refrescar pagina actual
export const refreshPage = () => {
    window.location.reload();
};
