<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Layout from "@/Layouts/Layout.vue";
import Table from './components/Table.vue'
import LinkButton from "@/Components/LinkButton.vue";


const props = defineProps({
    brands: Array,
});
</script>
<template>
    <Head title="Marcas" />
    <Layout>
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="flex justify-between overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Marcas
                        </h3>
                        <LinkButton
                            class="flex justify-center"
                            :href="route('utils.brands.create')"
                        >
                        <i class="bi bi-plus-circle"></i>
                        </LinkButton>

                    </div>
                </div>
                <div class="w-full">
                    <div>
                        <Table
                            :brands="brands"
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

