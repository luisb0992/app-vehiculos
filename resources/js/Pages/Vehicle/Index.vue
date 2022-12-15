<script setup>
import Layout from "@/Layouts/Layout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Toolbar from "primevue/toolbar";
import StatusVehicle from "./components/StatusVehicle.vue";
import { pp } from "@/Utils/Common/common";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { FilterMatchMode } from "primevue/api";
import { ref } from "vue";

const props = defineProps({
    vehicles: Array,
});

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
<template>
    <Head title="Listado de vehículos" />

    <Layout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white py-7 px-5 rounded-md">
                <div class="w-full pb-5">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Vehículos
                        </h3>
                    </div>
                </div>
                <div class="w-full py-5">
                    <Toolbar class="mb-4">
                        <template #start>
                            <Link
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded uppercase"
                                :href="route('vehicle.create')"
                            >
                                <i class="fas fa-plus"></i> Agregar Nuevo
                            </Link>
                        </template>
                    </Toolbar>
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
                        <Column field="status" header="Status" :sortable="true">
                            <template #body="{ data }">
                                <StatusVehicle :status="data.status" />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </Layout>
</template>
