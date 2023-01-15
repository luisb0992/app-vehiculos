<template lang="">
    <DataTable :value="users" :paginator="true" :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,50]" responsiveLayout="scroll"
            currentPageReportTemplate="VEr {first} a {last} de {totalRecords}" v-model:filters="filters1" filterDisplay="menu" >
        <template #header>
            <div class="flex justify-between">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters1['global'].value" placeholder="Busqueda..." class="w-52" />
                </span>
            </div>
        </template>
        <Column field="name" header="Nombre" :sortable="true"></Column>
        <Column field="last_name" header="Apellido" :sortable="true"></Column>
        <Column field="dni" header="DNI" :sortable="true"></Column>
        <Column field="email" header="Email" :sortable="true"></Column>
        <Column header="Taller" :sortable="true" >
            <template #body="{data}">
                {{data.workshop == null ? '---' : data.workshop.name}}
            </template>
        </Column>
        <Column field="rol_id" header="Rol" :filterMenuStyle="{'width':'14rem'}" :sortable="true">
            <template #body="{data}">
                <span :class="{
                    'bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded': data.rol.id == 1,
                    'bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded': data.rol.id != 1,
                }">{{data.rol.name}}</span>
            </template>
        </Column>
        <Column field="status" header="Status" :filterMenuStyle="{'width':'14rem'}" :sortable="true">
            <template #body="{data}">
                <span :class="{
                    'bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded': data.status == 1,
                    'bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded': data.status != 1,
                }">{{data.status == 1 ? 'Activo' : 'Inhabilitado'}}</span>
            </template>
        </Column>
        <Column style="min-width:8rem">
            <template #body="{data}">
                <div class="flex justify-between">
                    <Link :href="route('users.edit',data.id)" class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                        <i class="pi pi-pencil" />
                    </Link>
                    <button type="button" @click="handleDeleteUser(data.id)" class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
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
import Button from 'primevue/button';
import {ref} from 'vue'
import {FilterMatchMode} from 'primevue/api';
import InputText from 'primevue/inputtext';
import { Link } from '@inertiajs/inertia-vue3'
import {
    handleDeleteUser
} from "../modules/delete";

const props = defineProps({
    users: Array,
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
