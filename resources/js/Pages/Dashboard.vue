<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Layout from "@/Layouts/Layout.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";

const userIs = {
    super_admin:
        usePage().props.value.auth.user.rol_id ===
        usePage().props.value.roles.super_admin,
    recorder:
        usePage().props.value.auth.user.rol_id ===
        usePage().props.value.roles.recorder,
    supervisor:
        usePage().props.value.auth.user.rol_id ===
        usePage().props.value.roles.supervisor,
    supplier:
        usePage().props.value.auth.user.rol_id ===
        usePage().props.value.roles.supplier,
};
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <template #header>
            <h1 class="text-gray-900 text-2xl font-bold">
                Bienvenido {{ $page.props.auth.user.name }}
            </h1>
        </template>
        <div class="py-12 mx-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white py-5">
                    <div
                        class="flex justify-center md:justify-start items-center"
                    >
                        <div class="py-10 px-5 flex gap-5">
                            <div v-if="userIs.recorder">
                                <Link
                                    :href="route('vehicle.index')"
                                    class="border p-5 md:p-10 shadow-md bg-gray-50 hover:animate-shadow-drop-center"
                                >
                                    <span class="uppercase font-medium text-lg">
                                        Listado de Vehiculos
                                    </span>
                                </Link>
                                <!-- <Link
                                    :href="route('vehicle.create')"
                                    class="border p-5 md:p-10 shadow-md bg-gray-50 hover:animate-shadow-drop-center"
                                >
                                    <span class="uppercase font-medium text-lg">
                                        Nuevo ingreso vehicular
                                    </span>
                                </Link> -->
                            </div>
                            <div v-if="userIs.supplier">
                                <Link
                                    :href="route('workshop_quotes.index')"
                                    class="border p-5 md:p-10 shadow-md bg-gray-50 hover:animate-shadow-drop-center"
                                >
                                    <span class="uppercase font-medium text-lg">
                                        Solicitudes de reparación
                                    </span>
                                </Link>
                                <!-- <Link
                                    :href="route('workshop_quotes.index')"
                                    class="border p-5 md:p-10 shadow-md bg-gray-50 hover:animate-shadow-drop-center"
                                >
                                    <span class="uppercase font-medium text-lg">
                                        Solicitudes de reparación
                                    </span>
                                </Link> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
