<script setup>
import { ref } from "vue";
import NavBar from "@/Layouts/NavBar.vue";
import AlertDismiss from "@/Components/AlertDismiss.vue";
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gradient-to-br from-gray-800 to-gray-900">
            <NavBar />
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <!-- mostrar mensaje -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
                <AlertDismiss
                    :show-success="$page.props.flash.success ? true : false"
                    :show-danger="$page.props.flash.error ? true : false"
                />
            </div>
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
