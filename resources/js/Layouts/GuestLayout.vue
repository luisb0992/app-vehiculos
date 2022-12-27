<template>

    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"
    >
        <!-- mostrar mensaje -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <AlertDismiss
                :show-success="$page.props.flash.success ? true : false"
                :show-danger="$page.props.flash.error ? true : false"
            />
        </div>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
<script setup>
import AlertDismiss from "@/Components/AlertDismiss.vue";
</script>
