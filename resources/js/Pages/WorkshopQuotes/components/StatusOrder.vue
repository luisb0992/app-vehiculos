<script setup>
defineProps({
    status: Number,
});
</script>
<template>
    <div
        :class="{
            'text-blue-600 text-xs font-bold':
                status === $page.props.status.repair_order.open,
            'text-yellow-600 text-xs font-bold':
                status === $page.props.status.repair_order.in_repair,
            'text-green-600 text-xs font-bold':
                status === $page.props.status.repair_order.repaired,
        }"
    >
        <span v-if="status === $page.props.status.repair_order.open">
            Propuesta
        </span>
        <span v-if="status === $page.props.status.repair_order.in_repair">
            En reparación
        </span>
        <span v-else-if="status === $page.props.status.repair_order.repaired">
            Reparado
        </span>
        <span v-else class="text-gray-600 text-xs font-bold">
            Por cotizar
        </span>
    </div>
</template>
