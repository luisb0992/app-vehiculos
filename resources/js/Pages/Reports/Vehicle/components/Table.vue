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
            <div class="flex justify-between">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText
                        v-model="filter['global'].value"
                        placeholder="Búsqueda..."
                    />
                </span>
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
        <!-- <Column
            field="repair_orders_count"
            header="Reparación"
            :sortable="true"
        >
            <template #body="{ data }">
                <span
                    v-if="data.repair_orders_count"
                    class="font-medium text-sm text-zinc-900"
                >
                    <i
                        class="fas fa-check text-green-500"
                    ></i>
                    Solicitada
                </span>
                <Link
                    class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-2 rounded text-sm"
                    :href="route('vehicle.repair', data.id)"
                    v-else
                >
                    <i class="fas fa-info-circle"></i>
                    Solicitar
                </Link>
            </template>
        </Column> -->
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
});
console.log(props.vehicles)
const showdropdownDowload = ref(true);

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

/* const filters1 = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});

const initFilters1 = () => {
    filters1.value = {
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    }
}; */
const dt = ref();
const exportEXCEL = () => {
            //dt.value.exportEXCEL();
            alert('Excel')
        };

const exportPDF = () => {
   alert('PDF')
};


</script>
