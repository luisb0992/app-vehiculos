<template lang="">
    <DataTable :value="brands" :paginator="true" :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,50]" responsiveLayout="scroll"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" v-model:filters="filters1" filterDisplay="menu" >
        <template #header>
            <div class="flex justify-between">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters1['global'].value" placeholder="Busqueda..." class="w-52" />
                </span>
            </div>
        </template>
        <Column field="name" header="Nombre" :sortable="true" class="w-full"></Column>
        <Column style="min-width:8rem">
            <template #body="{data}">
                <div class="flex justify-between">
                    <Link :href="route('utils.brands.edit',data.id)" class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        <i class="pi pi-pencil" />
                    </Link>
                    <button type="button" @click="handleDelete(data.id)" class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        <i class="pi pi-trash" />
                    </button>
                </div>

            </template>
        </Column>
    </DataTable>
</template>

<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {ref} from 'vue'
import {FilterMatchMode} from 'primevue/api';
import InputText from 'primevue/inputtext';
import { Link } from '@inertiajs/inertia-vue3'
import {
    handleDelete
} from "../modules/delete";

const props = defineProps({
    brands: Array,
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
