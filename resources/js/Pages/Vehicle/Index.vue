<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { FilterMatchMode } from "primevue/api";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
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
                    <DataTable
                        :value="vehicles"
                        :paginator="true"
                        :rows="10"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        :rowsPerPageOptions="[10, 20, 50]"
                        responsiveLayout="scroll"
                        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords}"
                        v-model:filters="filter"
                        filterDisplay="menu"
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
                            :filterMenuStyle="{ width: '14rem' }"
                            :sortable="true"
                        >
                            <template #body="{ data }">
                                <p
                                    :class="{
                                        'bg-green-100 text-green-600 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded':
                                            data.status ===
                                            $page.props.status.vehicle
                                                .available,
                                        'bg-red-100 text-yellow-600 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded':
                                            data.status ===
                                            $page.props.status.vehicle.pending,
                                    }"
                                >
                                    <span
                                        v-if="
                                            data.status ===
                                            $page.props.status.vehicle.pending
                                        "
                                    >
                                        Pendiente
                                    </span>
                                    <span
                                        v-else-if="
                                            data.status ===
                                            $page.props.status.vehicle.available
                                        "
                                    >
                                        Disponible
                                    </span>
                                </p>
                            </template>
                        </Column>
                        <!-- <Column style="min-width: 8rem">
                            <template #body="{ data }">
                                <div class="flex justify-between">
                                    <Link
                                        :href="route('users.edit', data.id)"
                                        class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                                    >
                                        <i class="pi pi-pencil" />
                                    </Link>
                                    <button
                                        type="button"
                                        class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                                    >
                                        <i class="pi pi-trash" />
                                    </button>
                                </div>
                            </template>
                        </Column> -->
                    </DataTable>
                </div>
            </div>
        </div>
    </Layout>
</template>
