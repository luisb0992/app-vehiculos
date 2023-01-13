<script setup>
const props = defineProps({
    order: Object,
});
</script>
<template>
    <div>
        <span
            v-if="order.status === $page.props.status.repair_order.open"
            class="text-blue-400 font-bold"
        >
            Abierta | en espera
        </span>
        <span
            v-if="order.status === $page.props.status.repair_order.quoted"
            class="text-blue-600 font-bold"
        >
            Cotizada
        </span>
        <span
            v-if="order.status === $page.props.status.repair_order.approved"
            class="text-purple-600 font-bold"
        >
            Aprobada
        </span>
        <span
            v-if="order.status === $page.props.status.repair_order.in_repair"
            class="text-yellow-600 font-bold"
        >
            En reparación
        </span>
        <span
            v-if="order.status === $page.props.status.repair_order.repaired"
            class="text-green-600 font-bold"
        >
            Reparada
        </span>
        <span
            v-if="order.status === $page.props.status.repair_order.finalized"
            class="text-orange-600 font-bold"
        >
            Finalizado
        </span>
    </div>
</template>
