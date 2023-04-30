<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { computed } from "vue";
import ButtonShowImages from "./ButtonShowImages.vue";
import ButtonShowOrders from "./ButtonShowOrders.vue";

const props = defineProps({ vehicle: Object });
const id = computed(() => props.vehicle.id);
const status = computed(() => props.vehicle.status);
</script>
<template>
    <div
        :class="{
            'text-green-600 text-xs font-semibold':
                status === $page.props.status.vehicle.add,
            'text-orange-600 text-xs font-semibold':
                status === $page.props.status.vehicle.requested_repair,
            'text-blue-600 text-xs font-semibold':
                status === $page.props.status.vehicle.quoted,
            'text-purple-600 text-xs font-semibold':
                status === $page.props.status.vehicle.approved_quote,
            'text-red-600 text-xs font-semibold':
                status === $page.props.status.vehicle.rejected_quote,
            'text-gray-600 text-xs font-semibold':
                status === $page.props.status.vehicle.in_repair,
            'text-green-800 text-xs font-semibold':
                status === $page.props.status.vehicle.repaired,
            'text-lime-600 text-xs font-semibold':
                status === $page.props.status.vehicle.finalized,
            'text-orange-800 text-xs font-semibold':
                status === $page.props.status.vehicle.cancelled,
        }"
    >
        <!-- agregado -->
        <span v-if="status === $page.props.status.vehicle.add">
            <Link
                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-2 rounded md:text-sm text-xs"
                :href="route('vehicle.repair', id)"
            >
                <i class="fas fa-arrow-right"></i>
                Solicitar reparación
            </Link>
        </span>

        <!-- solicitud de reparación enviada -->
        <span
            v-else-if="status === $page.props.status.vehicle.requested_repair"
        >
            <p class="mb-3">
                Ordenes creadas ({{ vehicle.repair_orders_count }})
            </p>

            <div class="flex flex-col gap-3 w-28">
                <ButtonShowOrders @click="$emit('openQuotes', vehicle)" />
                <ButtonShowImages @click="$emit('openImages', vehicle)" />
            </div>
        </span>

        <!-- cotizado -->
        <span v-else-if="status === $page.props.status.vehicle.quoted">
            Cotización realizada
        </span>

        <!-- Cotización aprobada -->
        <span v-else-if="status === $page.props.status.vehicle.approved_quote">
            Cotización aprobada
        </span>

        <!-- Cotización rechazada -->
        <span v-else-if="status === $page.props.status.vehicle.rejected_quote">
            Cotización rechazada

            <Link
                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-2 rounded md:text-sm text-xs"
                :href="route('vehicle.repair', id)"
            >
                <i class="fas fa-arrow-right"></i>
                Solicitar nueva reparación
            </Link>
        </span>

        <!-- vehiculo en reparación -->
        <span v-else-if="status === $page.props.status.vehicle.in_repair">
            En reparación
        </span>

        <!-- vehiculo reparado -->
        <span v-else-if="status === $page.props.status.vehicle.repaired">
            Reparado
        </span>

        <!-- caso finalizado -->
        <span v-else-if="status === $page.props.status.vehicle.finalized">
            Caso finalizado

            <p class="mb-3 text-orange-600">
                Ordenes creadas ({{ vehicle.repair_orders_count }})
            </p>

            <div class="flex flex-col gap-3 w-28">
                <ButtonShowOrders @click="$emit('openQuotes', vehicle)" />
                <ButtonShowImages @click="$emit('openImages', vehicle)" />
            </div>
        </span>

        <!-- caso cancelado -->
        <span v-else-if="status === $page.props.status.vehicle.cancelled">
            Caso cancelado
        </span>
    </div>
</template>
