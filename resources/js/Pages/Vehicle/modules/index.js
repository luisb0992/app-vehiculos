/**
 * Gestión de funcionalidades para el index de vehiculos
 */

import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useForm } from "@inertiajs/inertia-vue3";
import { manageError } from "@/Utils/Common/common";

/**
 * Formulario con el estado
 */
export const form = useForm({
    status: "",
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
 * Filtrar datos por el estado seleccionado
 */
export const FilterData = () => {
    console.log(form.status);

    // filtrar datos
    form.get(route("vehicle.index"), {
        onStart: () => (form.loading = true),
        onSuccess: () => {
            console.log("success");
        },
        onError: () => manageError(),
        onFinish: () => (form.loading = false),
    });
};
