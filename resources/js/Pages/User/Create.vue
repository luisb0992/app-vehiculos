<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import UseForm from "./components/UseForm.vue";

import ButtonBack from "@/Components/ButtonBack.vue";

const props = defineProps({
    roles: Array,
    workshops: Array,
});
</script>
<template>
    <Head title="Nuevo Usuario" />

    <Layout>
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="flex justify-between overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Crear Usuario
                        </h3>
                        <ButtonBack
                            class="flex justify-center"
                            :href="route('users.index')"
                        />
                    </div>
                </div>
                <div class="w-full">
                    <UseForm
                        :roles="roles"
                        :workshops = "workshops"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>
