/**
 * Gestión de funcionalidades para el index de vehiculos
 */

import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";

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
 * Select de status
 */
export const filterStatus = ref("");

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
    console.log(filterStatus.value);
};
