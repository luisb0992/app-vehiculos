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
            'text-red-600 text-xs font-bold':
                status === $page.props.status.repair_order.canceled,
            'text-purple-600 text-xs font-bold':
                status === $page.props.status.repair_order.closed,
        }"
    >
        <span v-if="status === $page.props.status.repair_order.open">
            Por cotizar
        </span>
        <span v-if="status === $page.props.status.repair_order.in_repair">
            En reparación
        </span>
        <span v-else-if="status === $page.props.status.repair_order.repaired">
            Reparado
        </span>
        <span v-else-if="status === $page.props.status.repair_order.canceled">
            Cancelado
        </span>
        <span v-else-if="status === $page.props.status.repair_order.closed">
            Cerrado
        </span>
    </div>
</template>
