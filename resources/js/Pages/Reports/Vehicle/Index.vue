<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import Table from "./components/Table.vue";
import { defineProps, onMounted, ref, watch } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Datepicker from "@vuepic/vue-datepicker";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

const props = defineProps({
    brands: Array,
    models: Array,
    colors: Array,
    vehicles: Array,
    filters: Object,
    users: Array,
    status: Array,
});

const form = useForm({
    brand_id: props.filters.brand ?? "",
    model_id: props.filters.model ?? "",
    nro_chasis: props.filters.nro_chasis ?? "",
    user_id: props.filters.user_id ?? "",
    status: props.filters.status ?? "",
    dates: {
        start: "",
        end: "",
    },
});

const filterBrands = ref([]);
const filterModels = ref([]);
const date = ref();

const getBrands = (brands) => {
    const data = brands.filter((brand) => brand.brand_id === form.brand_id);
    filterBrands.value = data;

    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
        })
    );

    axios
        .post(route("reports.brands.models"), {
            brand_id: form.brand_id,
        })
        .then((res) => {
            props.models.push(...res.data);
        });
};

const getStatus = (status) => {
    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
    );
};

const getModels = (models) => {
    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
    );
    const data = models.filter((model) => model.id === form.model_id);
    filterModels.value = data;
};

const getUsers = (users) => {
    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        })
    );
};

// For demo purposes assign range from the current date
onMounted(() => {
    const startDate = new Date();
    const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
    date.value = null;
});

const format = (date) => {
    let day_start = date[0].getDate();
    let month_start = date[0].getMonth() + 1;
    let year_start = date[0].getFullYear();
    if (month_start < 10) {
        month_start = `0${month_start}`;
    }

    if (day_start < 10) {
        day_start = `0${day_start}`;
    }

    let day_end = date[1] == null ? "" : date[1].getDate();
    let month_end = date[1] == null ? "" : date[1].getMonth() + 1;
    let year_end = date[1] == null ? "" : date[1].getFullYear();
    if (month_end < 10) {
        month_end = `0${month_end}`;
    }

    if (day_end < 10) {
        day_end = `0${day_end}`;
    }
    form.dates.start = `${year_start}-${month_start}-${day_start}`;
    form.dates.end = `${year_end}-${month_end}-${day_end}`;

    return `${year_start}-${month_start}-${day_start} - ${year_end}-${month_end}-${day_end}`;
};

const changeDate = () => {
    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
        })
    );
};

const clearSelects = () => {
    form.brand_id = "";
    form.model_id = "";
    form.dates.start = "";
    form.dates.end = "";
    form.status = "";
    form.post(
        route("reports.post", form.value, {
            replace: true,
            preserveState: true,
        })
    );
};
</script>
<template>
    <Head title="Reporte de Vehiculos" />
    <Layout>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white p-7 rounded-md">
                    <div class="w-full pb-5">
                        <div
                            class="flex justify-between overflow-hidden shadow-sm sm:rounded-lg"
                        >
                            <h3 class="text-gray-900 text-2xl font-bold">
                                Reporte
                            </h3>
                        </div>
                    </div>
                    <div
                        class="bg-gray-100 w-full p-6 mb-4 rounded-lg shadow-sm"
                    >
                        <form>
                            <span class="font-bold text-xl mb-2"
                                >Filtros
                                <i class="pi pi-arrow-right-arrow-left"></i
                            ></span>
                            <div
                                class="grid grid-cols-1 md:lg:grid-cols-2 gap-5 mb-4"
                            >
                                <div>
                                    <InputLabel for="brand" value="Marca" />
                                    <select
                                        id="marca"
                                        class="mt-1 block w-full border-gray-200 border"
                                        v-model="form.brand_id"
                                        required
                                        @change="getBrands(brands)"
                                    >
                                        <option value="">
                                            Seleccione una marca
                                        </option>
                                        <option
                                            v-for="brand in brands"
                                            :key="brand.id"
                                            :value="brand.id"
                                        >
                                            {{ brand.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" />
                                </div>
                                <div class="flex-1">
                                    <InputLabel for="model" value="Modelo" />
                                    <select
                                        id="modelo"
                                        class="mt-1 block w-full border-gray-200 border"
                                        v-model="form.model_id"
                                        required
                                        @change="getModels(models)"
                                    >
                                        <option value="">
                                            Seleccione un modelo
                                        </option>
                                        <option
                                            v-for="model in models"
                                            :key="model.id"
                                            :value="model.id"
                                        >
                                            {{ model.name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" />
                                </div>
                                <div>
                                    <InputLabel
                                        for="date"
                                        value="Fecha"
                                        class="mb-1"
                                    />
                                    <Datepicker
                                        @update:modelValue="changeDate()"
                                        :format="format"
                                        cancelText="Cancelar"
                                        selectText="Seleccionar"
                                        v-model="date"
                                        range
                                        locale="es"
                                        multi-calendars
                                        placeholder="Seleccionar Fecha"
                                        :enable-time-picker="false"
                                    />
                                    <InputError class="mt-2" />
                                </div>
                                <div class="flex-1">
                                    <InputLabel
                                        for="user"
                                        value="Usuario Registrador"
                                    />
                                    <select
                                        id="user"
                                        class="mt-1 block w-full border-gray-200 border"
                                        v-model="form.user_id"
                                        required
                                        @change="getUsers(users)"
                                    >
                                        <option value="">
                                            Seleccione un usuario registrador
                                        </option>
                                        <option
                                            v-for="user in users"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }} {{ user.last_name }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" />
                                </div>
                                <div class="flex-1">
                                    <InputLabel
                                        for="status"
                                        value="Estatus de orden"
                                    />
                                    <select
                                        id="status"
                                        class="mt-1 block w-full border-gray-200 border"
                                        v-model="form.status"
                                        required
                                        @change="getStatus(status)"
                                    >
                                        <option value="">
                                            Seleccione un status
                                        </option>
                                        <option
                                            v-for="(item, index) in status"
                                            :value="index"
                                        >
                                            {{ item }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" />
                                </div>
                            </div>
                            <span class="font-bold text-xl mb-2">
                                Búsqueda <i class="pi pi-search"></i>
                            </span>
                            <div
                                class="grid grid-cols-1 md:lg:grid-cols-3 gap-5 mt-2"
                            >
                                <div>
                                    <InputLabel
                                        for="chasis"
                                        value="Nro Chasis"
                                    />
                                    <TextInput
                                        id="chasis"
                                        class="mt-1 block w-full border-gray-200 border p-2 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                        v-model="form.nro_chasis"
                                        required
                                        @input="clearSelects()"
                                    />
                                    <InputError class="mt-2" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="w-full">
                        <div>
                            <Table :vehicles="vehicles" :form="form" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
