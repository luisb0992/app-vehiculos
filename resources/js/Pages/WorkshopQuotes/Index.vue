<script setup>
import Layout from "@/Layouts/Layout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import StatusOrder from "./components/StatusOrder.vue";
import { formatDate, pp, refreshPage } from "@/Utils/Common/common";
import { Head } from "@inertiajs/inertia-vue3";
import { FilterMatchMode } from "primevue/api";
import { ref } from "vue";

const props = defineProps({
    orders: Array,
});

const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
<template>
    <Head title="Solicitudes de reparación" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 border-2 border-turquesa rounded-lg">
                    <div class="w-full pb-5">
                        <div
                            class="flex flex-col md:flex-row md:justify-between items-center"
                        >
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Solicitudes de reparación
                            </h3>
                            <p
                                class="text-blue-800 text-xl font-bold uppercase"
                            >
                                taller:
                                <span class="font-normal text-blue-800">
                                    {{
                                        $page.props.auth.user?.workshop?.name ??
                                        "DESCONOCIDO"
                                    }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="w-full py-5">
                        <DataTable
                            :value="orders"
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
                                <div class="flex flex-col md:flex-row gap-5">
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filter['global'].value"
                                            placeholder="Búsqueda..."
                                            class="w-52"
                                        />
                                    </span>
                                    <button
                                        class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded uppercase"
                                        type="button"
                                        @click.stop="refreshPage"
                                    >
                                        <i class="fas fa-sync"></i> Actualizar
                                    </button>
                                </div>
                            </template>
                            <Column
                                field="vehicle.gallery[0]?.path"
                                header="Imagen"
                                style="min-width: 10rem"
                            >
                                <template #body="{ data }" class="w-40">
                                    <img
                                        :src="
                                            pp.resizeImgVehicle.value +
                                            data.vehicle.gallery[0]?.path
                                        "
                                        class="w-full md:w-28 h-20 rounded"
                                    />
                                </template>
                            </Column>
                            <Column
                                field="vehicle.chassis_number"
                                header="Nº chasis"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="vehicle.brand.name"
                                header="Marca"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="vehicle.model.name"
                                header="Modelo"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="vehicle.color.name"
                                header="Color"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="quotation.created_at"
                                header="Fecha de cotización"
                                :sortable="true"
                            >
                                <template #body="{ data }">
                                    <span v-if="data.quotation">
                                        {{ formatDate(data.quotation.created_at) }}
                                    </span>
                                    <span v-else class="text-orange-700">
                                        No cotizada
                                    </span>
                                </template>
                            </Column>
                            <Column
                                field="status"
                                header="Status Reparación"
                                :sortable="true"
                                style="min-width: 15rem"
                            >
                                <template #body="{ data }">
                                    <StatusOrder
                                        :status="data.status"
                                        :id="data.id"
                                        :order="data"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
