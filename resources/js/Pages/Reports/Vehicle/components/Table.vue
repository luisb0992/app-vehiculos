<template lang="">
    <DataTable
        :value="vehicles"
        :paginator="true"
        :rows="10"
        :filters="filter"
        :rowsPerPageOptions="[10, 20, 50]"
        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords}"
        responsiveLayout="scroll"
        dataKey="id"
        :loading="loading1"
    >
        <ColumnGroup type="header">
            <Row>
                <Column header="" :colspan="6" />
                <Column
                    header="Monto Reparación"
                    :colspan="3"
                    class="font-extrabold"
                />
            </Row>
            <Row>
                <Column
                    header="Nro Chasis"
                    :sortable="true"
                    field="chassis_number"
                />
                <Column header="Marca" :sortable="true" field="brand" />
                <Column header="Modelo" :sortable="true" field="model" />
                <Column header="Usuario R." :sortable="true" field="user" />
                <Column
                    header="Estatus de Reparación"
                    :sortable="true"
                    field="status"
                />
                <Column
                    header="Muelle"
                    :sortable="true"
                    style="background-color: #d4f5f1"
                    field="dock"
                />
                <Column
                    header="Garantía"
                    :sortable="true"
                    style="background-color: #d4f5f1"
                    field="warranty"
                />
                <Column
                    header="Total"
                    :sortable="true"
                    style="background-color: #d4f5f1"
                    field="total"
                />
            </Row>
        </ColumnGroup>
        <template #header>
            <div
                class="flex gap-3 justify-content-center align-center align-items-center justify-center md:lg:justify-between flex-col md:lg:flex-row"
            >
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="filter['global'].value"
                        placeholder="Búsqueda..."
                        class="w-52"
                    />
                </span>
                <div class="flex gap-2 flex-col md:lg:flex-row items-center">
                    <div class="align-center">
                        <a
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :href="route('reports.excel', form)"
                        >
                            <i class="pi pi-file-excel"></i>
                            <span class="px-3 py-1 uppercase"> Excel </span>
                        </a>
                    </div>
                    <div class="align-center">
                        <a
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :href="route('reports.pdf', form)"
                        >
                            <i class="pi pi-file-pdf"></i>
                            <span class="px-3 py-1 uppercase"> PDF </span>
                        </a>
                    </div>
                </div>
            </div>
        </template>
        <Column
            field="chassis_number"
            header="Nº chasis"
            :sortable="true"
        ></Column>
        <Column field="brand" header="Marca" :sortable="true"></Column>
        <Column field="model" header="Modelo" :sortable="true"></Column>
        <Column field="user" header="Usuario R." :sortable="true"></Column>
        <Column field="status" header="Status" :sortable="true">
            <template #body="{ data }">
                {{ data.status_last_order }}
            </template>
        </Column>
        <Column field="dock">
            <template #body="slotProps">
                {{ formatCurrency(slotProps.data.dock) }}
            </template>
        </Column>
        <Column field="warranty">
            <template #body="slotProps">
                {{ formatCurrency(slotProps.data.warranty) }}
            </template>
        </Column>
        <Column field="total">
            <template #body="slotProps">
                {{ formatCurrency(slotProps.data.total) }}
            </template>
        </Column>
        <Column style="min-width: 8rem">
            <template #body="{ data }">
                <div class="flex justify-between">
                    <button
                        type="button"
                        @click="openModalVehicle(data)"
                        class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                    >
                        Ver Detalles
                    </button>
                    <a
                        :href="route('reports.vehicle.pdf', data.id)"
                        target="_blank"
                        class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                    >
                        Descargar Reporte
                    </a>
                </div>
            </template>
        </Column>
        <ColumnGroup type="footer">
            <Row>
                <Column
                    footer="Totals:"
                    :colspan="5"
                    footerStyle="text-align:right"
                />
                <Column :footer="dockTotal" footerStyle="text-align:center" />
                <Column
                    :footer="warrantyTotal"
                    footerStyle="text-align:center"
                />
                <Column :footer="totalData" footerStyle="text-align:center" />
            </Row>
        </ColumnGroup>
    </DataTable>
    <ModalVehicle
        :show="displayMaximizable"
        :vehicle="dataModal"
        @close="closeMaximizable"
    />
</template>

<script setup>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted, computed } from "vue";
import { FilterMatchMode } from "primevue/api";
import InputText from "primevue/inputtext";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import ModalVehicle from "./ModalVehicle.vue";

const props = defineProps({
    vehicles: Array,
    form: Object,
});

const dockTotal = computed(() => {
    let total = 0;
    for (let dock of props.vehicles) {
        total += dock.dock;
    }

    return formatCurrency(total);
});

const warrantyTotal = computed(() => {
    let total = 0;
    for (let warranty of props.vehicles) {
        total += warranty.warranty;
    }

    return formatCurrency(total);
});

const totalData = computed(() => {
    let total = 0;
    for (let totalAll of props.vehicles) {
        total += totalAll.total;
    }

    return formatCurrency(total);
});

const loading1 = ref(true);
const displayMaximizable = ref(false);
const dataModal = ref({});

const openModalVehicle = (data) => {
    dataModal.value = { ...data };
    displayMaximizable.value = true;
};

const closeMaximizable = () => {
    displayMaximizable.value = false;
};

onMounted(() => {
    loading1.value = false;
});

const formatCurrency = (value) => {
    return value.toLocaleString("en-US", {
        style: "currency",
        currency: "USD",
    });
};

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
