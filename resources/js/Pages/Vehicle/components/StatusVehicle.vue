<script setup>
defineProps({
    status: Number,
});
</script>
<template>
    <div
        :class="{
            'text-green-600 text-xs font-bold':
                status === $page.props.status.vehicle.repaired,
            'text-yellow-600 text-xs font-bold':
                status === $page.props.status.vehicle.pending,
            'text-gray-600 text-xs font-bold':
                status !== $page.props.status.vehicle.repaired &&
                status !== $page.props.status.vehicle.pending,
        }"
    >
        <span v-if="status === $page.props.status.vehicle.pending">
            Pendiente
        </span>
        <span v-else-if="status === $page.props.status.vehicle.repaired">
            Reparado
        </span>
        <span v-else>
            No definido
        </span>
    </div>
</template>
