/**
 * Gestión de funcionalidades para el index de vehiculos
 */

import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useForm } from "@inertiajs/inertia-vue3";
import { manageError } from "@/Utils/Common/common";
import { pp } from "@/Utils/Common/common";

/**
 * Formulario con el estado
 */
export const form = useForm({
    status: "",
    date_from: "",
    date_to: "",
    date: null,
    loading: false,
});

/**
 * Filtros de búsqueda
 */
export const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

/**
 * estado del modal de cotizaciones
 */
export const showQuotesModal = ref(false);

/**
 * Estado del modal de imagenes
 */
export const showImagesModal = ref(false);

/**
 * Datos del vehiculo
 */
export const vehicle = ref({});

/**
 * Abre el modal de cotizaciones y estado de ordenes
 *
 * @param {Object} data   Datos del vehiculo
 */
export const openModalQuotes = (data) => {
    vehicle.value = data;
    showQuotesModal.value = true;
};

/**
 * Abrir el modal de imagenes del vehiculo
 */
export const openModalImages = (veh) => {
    vehicle.value = veh;
    showImagesModal.value = true;
};

/**
 * Filtrar datos por el estado seleccionado
 *
 */
export const FilterData = () => {
    // filtrar datos
    form.get(route("vehicle.index"), {
        onStart: () => (form.loading = true),
        onSuccess: () => console.info("success"),
        onError: () => manageError(),
        onFinish: () => (form.loading = false),
    });
};

/**
 * Limpiar la data necesaria cuando se limpia el picker
 */
export const clearedData = () => {
    form.date_from = "";
    form.date_to = "";

    FilterData();
};

/**
 * Formato para el datepicker
 */
export const format = (date) => {
    let day_start = date[0].getDate();
    let month_start = date[0].getMonth() + 1;
    let year_start = date[0].getFullYear();
    if (month_start < 10) {
        month_start = `0${month_start}`;
    }

    if (day_start < 10) {
        day_start = `0${day_start}`;
    }

    let day_end = date[1] == null ? "" : date[1].getDate();
    let month_end = date[1] == null ? "" : date[1].getMonth() + 1;
    let year_end = date[1] == null ? "" : date[1].getFullYear();
    if (month_end < 10) {
        month_end = `0${month_end}`;
    }

    if (day_end < 10) {
        day_end = `0${day_end}`;
    }

    form.date_from = `${year_start}-${month_start}-${day_start}`;
    form.date_to = `${year_end}-${month_end}-${day_end}`;

    return `${year_start}-${month_start}-${day_start} - ${year_end}-${month_end}-${day_end}`;
};

/**
 * Path de la imagen
 */
export const pathImage = (image) => {
    return `${pp.resizeImgVehicle.value + image}`;
};
