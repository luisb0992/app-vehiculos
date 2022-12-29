<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import Table from './components/Table.vue'

const props = defineProps({
    logs: Array,
});
</script>
<template>
    <Head title="Bítacora" />
    <Layout>
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="flex justify-between overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Bítacora
                        </h3>
                    </div>
                </div>
                <div class="w-full">
                    <div>
                        <Table
                            :logs="logs"
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

