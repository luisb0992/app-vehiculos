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
    >
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
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('vehicle.reports.excel',form)">
                            <i class="pi pi-file-excel"></i>
                            <span class="px-3 py-1 uppercase"> Excel </span>
                        </a>
                    </div>
                    <div class="align-center">
                        <a target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" :href="route('vehicle.reports.pdf',form)">
                            <i class="pi pi-file-pdf"></i>
                            <span class="px-3 py-1 uppercase"> PDF </span>
                        </a>
                    </div>
                </div>
            </div>
        </template>
        <Column
            field="gallery"
            header="Imagen"
            style="min-width: 10rem"
        >
            <template #body="{ data }" class="w-40">
                <img
                    :src="
                        pp.resizeImgVehicle.value +
                        data.gallery[0]?.path
                    "
                    class="w-full md:w-28 h-20 rounded"
                />
            </template>
        </Column>
        <Column
            field="chassis_number"
            header="Nº chasis"
            :sortable="true"
        ></Column>
        <Column
            field="brand.name"
            header="Marca"
            :sortable="true"
        ></Column>
        <Column
            field="model.name"
            header="Modelo"
            :sortable="true"
        ></Column>
        <Column
            field="color.name"
            header="Color"
            :sortable="true"
        ></Column>
        <Column
            field="status"
            header="Status"
            :sortable="true"
        >
            <template #body="{ data }">
                <StatusVehicle :status="data.status" />
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { pp } from "@/Utils/Common/common";
import StatusVehicle from "@/Pages/Vehicle/components/StatusVehicle.vue";


const props = defineProps({
    vehicles: Array,
    form : Object
});
const showdropdownDowload = ref(true);

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

</script>
