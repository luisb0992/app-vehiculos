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
            <!-- <Row>
                <Column header="Nro Chasis" :rowspan="3" />
            </Row> -->
            <Row>
                <Column header="" :colspan="6" />
                <Column header="Monto Reparación" :colspan="3" class="font-extrabold" />
                <!-- <Column header="Profits" :colspan="2" /> -->
            </Row>
            <Row>
                <Column header="Nro Chasis" :sortable="true"/>
                <Column header="Marca" :sortable="true"/>
                <Column header="Modelo" :sortable="true"/>
                <Column header="Usuario R." :sortable="true"/>
                <Column header="Estatus" :sortable="true"/>
                <Column header="Muelle" :sortable="true" style="background-color: #D4F5F1" field="dock"/>
                <Column header="Garantía" :sortable="true" style="background-color: #D4F5F1" field="warranty"/>
                <Column header="Total" :sortable="true" style="background-color: #D4F5F1" field="total"/>
            </Row>
        </ColumnGroup>
        <template #header>
            <div class="flex gap-3 justify-content-center align-center align-items-center justify-center md:lg:justify-between flex-col md:lg:flex-row">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="filter['global'].value"
                        placeholder="Búsqueda..."
                    />
                </span>
                <div class="flex gap-4">
                    <div class="align-center">
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('reports.excel',form)">
                            <i class="pi pi-file-excel"></i>
                            <span class="px-3 py-1 uppercase"> Excel </span>
                        </a>
                    </div>
                    <div class="align-center">
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('reports.pdf',form)">
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
        <Column
            field="brand"
            header="Marca"
            :sortable="true"
        ></Column>
        <Column
            field="model"
            header="Modelo"
            :sortable="true"
        ></Column>
        <Column
            field="user"
            header="Ususario R."
            :sortable="true"
        ></Column>
        <Column
            field="status"
            header="Status"
            :sortable="true"
        >
            <template #body="{ data }">
                <Badge v-if="data.status == 1" value="Disponible" class="mr-2" severity="success" ></Badge>
                <Badge v-if="data.status == 2" value="Pendiente" aria-label="Tabable Primary Badge" tabindex="0" class="mr-2"></Badge>
                <Badge v-if="data.status == 3" value="Mantenimiento" severity="info" class="mr-2"></Badge>
                <Badge v-if="data.status == 4" value="Reparado" severity="warning" class="mr-2"></Badge>
                <Badge v-if="data.status == 5" value="Eliminado" severity="danger"></Badge>
            </template>
        </Column>
        <Column field="dock">
            <template #body="slotProps">
               {{formatCurrency(slotProps.data.dock)}}
            </template>
        </Column>
        <Column field="warranty">
            <template #body="slotProps">
               {{formatCurrency(slotProps.data.warranty)}}
            </template>
        </Column>
        <Column field="total">
            <template #body="slotProps">
               {{formatCurrency(slotProps.data.total)}}
            </template>
        </Column>
        <Column style="min-width:8rem">
            <template #body="{data}">
                <div class="flex justify-between">
                    <button type="button" @click="openMaximizable" class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        <i class="pi pi-eye" />
                    </button>
                    <a target="_blank" class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        <i class="pi pi-file-pdf" />
                    </a>
                </div>
            </template>
        </Column>
    </DataTable>
    <Dialog header="Header" v-model:visible="displayMaximizable" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :maximizable="true" :modal="true">
            <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <template #footer>
                <Button label="No" icon="pi pi-times" @click="closeMaximizable" class="p-button-text"/>
                <Button label="Yes" icon="pi pi-check" @click="closeMaximizable" autofocus />
            </template>
        </Dialog>
    <!-- <ModalVehicle :displayMaximizable="displayMaximizable" /> -->
</template>

<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {ref,onMounted} from 'vue'
import {FilterMatchMode} from 'primevue/api';
import InputText from 'primevue/inputtext';
import Badge from 'primevue/badge';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import { Link } from '@inertiajs/inertia-vue3'
import ModalVehicle from './ModalVehicle.vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';


const props = defineProps({
    vehicles: Array,
    form : Object
});
const showdropdownDowload = ref(true);
const loading1 = ref(true);
const displayMaximizable = ref(false);
const openMaximizable = () => {

            displayMaximizable.value = true;
        };

onMounted(() => {
    loading1.value = false;
})

const formatCurrency = (value) => {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
};

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

</script>
