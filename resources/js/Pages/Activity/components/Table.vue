<template lang="">
    <DataTable :value="logs" :paginator="true" :rows="10" ref="dt"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,50]" responsiveLayout="scroll"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters1" filterDisplay="menu" >
        <template #header>
            <div class="flex justify-content-center align-center align-items-center justify-center md:lg:justify-between flex-col md:lg:flex-row">
                <span class="p-input-icon-left mb-5">
                    <InputText v-model="filters1['global'].value" placeholder="Busqueda..." class="w-52" />
                </span>
                <div class="flex gap-2 flex-col md:lg:flex-row items-center">
                    <div class="align-center">
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('logs.excel')">
                            <i class="pi pi-file-excel"></i>
                            <span class="px-3 py-1 uppercase"> Excel </span>
                        </a>
                    </div>
                    <div class="align-center">
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('logs.pdf')">
                            <i class="pi pi-file-pdf"></i>
                            <span class="px-3 py-1 uppercase"> PDF </span>
                        </a>
                    </div>
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



</script>
