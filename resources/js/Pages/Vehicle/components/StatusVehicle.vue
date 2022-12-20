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
            'text-blue-600 text-xs font-bold':
                status === $page.props.status.vehicle.add,
        }"
    >
        <span v-if="status === $page.props.status.vehicle.pending">
            Pendiente por reparar
        </span>
        <span v-else-if="status === $page.props.status.vehicle.repaired">
            Reparado
        </span>
        <span v-else-if="status === $page.props.status.vehicle.add">
            Agregado
        </span>
    </div>
</template>
