<template>

    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-600 to-gray-900"
    >
        <!-- mostrar mensaje -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <AlertDismiss
                :show-success="$page.props.flash.success ? true : false"
                :show-danger="$page.props.flash.error ? true : false"
            />
        </div>
        <div
            class="w-full mt-6 px-6 py-4"
        >
            <slot />
        </div>
    </div>
</template>
<script setup>
import AlertDismiss from "@/Components/AlertDismiss.vue";
</script>
