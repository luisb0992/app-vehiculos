<template lang="">
    <DataTable :value="logs" :paginator="true" :rows="10" ref="dt"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,50]" responsiveLayout="scroll"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters1" filterDisplay="menu" >
        <template #header>
            <div class="flex justify-content-center align-center align-items-center justify-center md:lg:justify-between flex-col md:lg:flex-row">
                <span class="p-input-icon-left mb-5">
                    <i class="pi pi-search" />
                    <InputText v-model="filters1['global'].value" placeholder="Busqueda..." />
                </span>
                <div class="align-center">
                    <PrimaryButton icon="pi pi-external-link" label="Export" @click="exportCSV($event)">
                        <span class="px-3 py-1 uppercase"> Exportar CSV </span>
                    </PrimaryButton>
                </div>
            </div>
        </template>
        <Column field="module" header="Modulo" :sortable="true" class="w-1/4" exportHeader="Modulo"></Column>
        <Column field="user" header="Usuario" :sortable="true" class="w-full" exportHeader="Usuario"></Column>
        <Column field="subject" header="Sujeto" :sortable="true" class="w-full" exportHeader="Sujeto"></Column>
        <Column field="date" header="Fecha" :sortable="true" class="w-full" exportHeader="Fecha"></Column>
        <Column field="user_agent" header="Plataforma" :sortable="true" class="w-full" exportHeader="Plataforma"></Column>
        <Column field="ip" header="IP" :sortable="true" class="w-full" exportHeader="IP"></Column>
        <Column field="proceso" header="Proceso" :sortable="true" class="w-full" exportHeader="Proceso"></Column>
    </DataTable>
</template>

<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {ref} from 'vue'
import {FilterMatchMode} from 'primevue/api';
import InputText from 'primevue/inputtext';
import { Link } from '@inertiajs/inertia-vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue";
/* import {
    handleDelete
} from "../modules/delete"; */

const props = defineProps({
    logs: Array,
});


const filters1 = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

const initFilters1 = () => {
    filters1.value = {
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    }
};
const dt = ref();
const exportCSV = () => {
            dt.value.exportCSV();
        };


</script>
