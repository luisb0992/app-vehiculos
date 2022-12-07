<script setup>
import Layout from "@/Layouts/Layout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
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
                    <div class="flex justify-center md:justify-start items-center">
                        <div class="py-10 px-5">
                            <Link
                                :href="route('vehicle.create')"
                                class="border p-5 md:p-10 shadow-md bg-gray-50 hover:animate-shadow-drop-center"
                            >
                                <span class="uppercase font-medium text-lg">
                                    Nuevo ingreso vehicular
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout >
</template>
