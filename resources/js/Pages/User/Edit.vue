<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import EditForm from "./components/EditForm.vue";

import ButtonBack from "@/Components/ButtonBack.vue";

const props = defineProps({
    roles: Array,
    workshops: Array,
    user : Object
});
</script>
<template>
    <Head title="Editar Usuario" />

    <Layout>
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="flex justify-between overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Editar Usuario
                        </h3>
                        <ButtonBack
                            class="flex justify-center"
                            :href="route('users.index')"
                        />
                    </div>
                </div>
                <div class="w-full">
                    <EditForm
                        :roles="roles"
                        :workshops = "workshops"
                        :user = "user"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>
