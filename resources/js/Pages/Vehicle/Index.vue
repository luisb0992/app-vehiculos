<script setup>
import Layout from "@/Layouts/Layout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Toolbar from "primevue/toolbar";
import StatusVehicle from "./components/StatusVehicle.vue";
import QuotesModal from "./components/QuotesModal.vue";
import ImagesModal from "./components/ImagesModal.vue";
import Datepicker from "@vuepic/vue-datepicker";
import { refreshPage } from "@/Utils/Common/common";
import { Head, Link } from "@inertiajs/inertia-vue3";
import {
    filter,
    showQuotesModal,
    showImagesModal,
    vehicle,
    openModalQuotes,
    openModalImages,
    FilterData,
    clearedData,
    form,
    format,
    pathImage,
} from "./modules/index";

defineProps({ vehicles: Array });
</script>
<template>
    <Head title="Listado de vehículos" />

    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-5 border-2 border-turquesa rounded-lg">
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
                                <div
                                    class="flex flex-col md:flex-row md:justify-start gap-8"
                                >
                                    <Link
                                        class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded uppercase"
                                        :href="route('vehicle.create')"
                                    >
                                        <i class="fas fa-plus"></i> Agregar
                                        Nuevo
                                    </Link>

                                    <button
                                        class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded uppercase"
                                        type="button"
                                        @click.stop="refreshPage"
                                    >
                                        <i class="fas fa-sync"></i> Actualizar
                                    </button>
                                </div>
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
                            <!-- filtros -->
                            <template #header>
                                <div
                                    class="flex flex-col md:flex-row justify-start gap-5"
                                >
                                    <div class="flex flex-col">
                                        <label>Búsqueda</label>
                                        <span class="p-input-icon-left">
                                            <i class="pi pi-search" />
                                            <InputText
                                                v-model="filter['global'].value"
                                                placeholder="Búsqueda..."
                                                class="w-52 h-[38px]"
                                            />
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <label>Periodo</label>
                                        <select
                                            class="pl-3 h-[38px] text-sm text-gray-700 font-light rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300"
                                            v-model="form.status"
                                            @change="FilterData"
                                        >
                                            <option value="">Todos</option>
                                            <option value="3">
                                                Por aprobar
                                            </option>
                                            <option value="6">
                                                En reparación
                                            </option>
                                            <option value="8">
                                                Finalizadas
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col">
                                        <label>Fechas</label>
                                        <div
                                            class="flex flex-col md:flex-row gap-5"
                                        >
                                            <div>
                                                <Datepicker
                                                    @update:modelValue="
                                                        FilterData()
                                                    "
                                                    @cleared="clearedData"
                                                    :format="format"
                                                    cancelText="Cancelar"
                                                    selectText="Seleccionar"
                                                    v-model="form.date"
                                                    range
                                                    locale="es"
                                                    multi-calendars
                                                    placeholder="Seleccionar Fechas..."
                                                    :enable-time-picker="false"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <!-- /filtros -->

                            <!-- columnas -->
                            <Column
                                field="gallery"
                                header="Imagen"
                                style="min-width: 10rem"
                            >
                                <template #body="{ data }" class="w-40">
                                    <img
                                        :src="pathImage(data.gallery[0]?.path)"
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
                                field="created_at"
                                header="Fecha de ingreso"
                                :sortable="true"
                            >
                                <template #body="{ data }">
                                    {{ formatPickerDate(data.created_at) }}
                                </template>
                            </Column>
                            <Column
                                field="status"
                                header="Status Reparación"
                                :sortable="true"
                                style="min-width: 15rem"
                            >
                                <template #body="{ data }">
                                    <StatusVehicle
                                        :vehicle="data"
                                        @openQuotes="openModalQuotes"
                                        @openImages="openModalImages"
                                    />
                                </template>
                            </Column>
                            <!-- /columnas -->
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>

        <QuotesModal
            :show="showQuotesModal"
            :vehicle="vehicle"
            @close="showQuotesModal = false"
        />

        <ImagesModal
            :show="showImagesModal"
            :vehicle="vehicle"
            @close="showImagesModal = false"
        />
    </Layout>
</template>
