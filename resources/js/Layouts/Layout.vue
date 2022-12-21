<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
</script>
<template>
    <AuthenticatedLayout v-if="$page.props.auth.user.rol_id != 1">
        <slot />
    </AuthenticatedLayout>
    <AdminLayout v-if="$page.props.auth.user.rol_id == 1">
        <slot />
    </AdminLayout>
</template>
