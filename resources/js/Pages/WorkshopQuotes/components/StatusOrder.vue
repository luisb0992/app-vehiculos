<script setup>
import { manageError } from "@/Utils/Common/common";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2/dist/sweetalert2";

const props = defineProps({
    status: Number,
    id: Number,
});

const startRepair = () => {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, iniciar reparación!",
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({ order_id: props.id });

            form.post(route("workshop_quotes.startRepair"), {
                onSuccess: () => {
                    Swal.fire(
                        "¡Reparación iniciada!",
                        "La reparación ha sido iniciada.",
                        "success"
                    );
                },
                onError: () => manageError(),
            });
        }
    });
};

const finishRepair = () => {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, finalizar reparación!",
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({ order_id: props.id });

            form.post(route("workshop_quotes.finishRepair"), {
                onSuccess: () => {
                    Swal.fire(
                        "¡Reparación Finalizada!",
                        "La reparación ha sido finalizada. se le notificará al usuario.",
                        "success"
                    );
                },
                onError: () => manageError(),
            });
        }
    });
};
</script>
<template>
    <div
        :class="{
            'text-blue-600 text-xs font-semibold':
                status === $page.props.status.repair_order.open,
            'text-blue-600 text-xs font-semibold':
                status === $page.props.status.repair_order.quoted,
            'text-purple-600 text-xs font-semibold':
                status === $page.props.status.repair_order.approved,
            'text-yellow-600 text-xs font-semibold':
                status === $page.props.status.repair_order.in_repair,
            'text-red-600 text-xs font-semibold':
                status === $page.props.status.repair_order.cancelLed,
            'text-orange-600 text-xs font-semibold':
                status === $page.props.status.repair_order.repaired,
            'text-green-600 text-xs font-semibold':
                status === $page.props.status.repair_order.finalized,
        }"
        class="text-center"
    >
        <!-- por cotizar - abierta -->
        <span v-if="status === $page.props.status.repair_order.open">
            <Link
                :href="route('workshop_quotes.createQuote', id)"
                class="hover:no-underline bg-blue-100 px-3 py-2 hover:bg-blue-300 text-blue-600 hover:text-blue-900 rounded-lg text-xs font-bold"
            >
                <i class="fas fa-arrow-right"></i>
                Cotizar ahora
            </Link>
        </span>

        <!-- cotizada -->
        <span v-if="status === $page.props.status.repair_order.quoted">
            Reparación cotizada
        </span>

        <!-- aprobada -->
        <span v-if="status === $page.props.status.repair_order.approved">
            <p class="pb-1">Cotización aprobada</p>

            <button
                class="hover:no-underline bg-purple-100 px-3 py-2 hover:bg-purple-300 text-purple-600 hover:text-purple-900 rounded-lg text-xs font-bold"
                @click="startRepair"
            >
                <i class="fas fa-arrow-right"></i>
                Iniciar reparación
            </button>
        </span>

        <!-- en repació -->
        <span v-if="status === $page.props.status.repair_order.in_repair">
            <p class="pb-1">Vehiculo en reparación</p>

            <button
                class="hover:no-underline bg-yellow-100 px-3 py-2 hover:bg-yellow-300 text-yellow-600 hover:text-yellow-900 rounded-lg text-xs font-bold"
                @click="finishRepair"
            >
                <i class="fas fa-arrow-right"></i>
                Finalizar reparación
            </button>
        </span>

        <!-- orden cancelada -->
        <span v-if="status === $page.props.status.repair_order.cancelLed">
            Orden cancelada
        </span>

        <!-- vehiculo reparado -->
        <span v-if="status === $page.props.status.repair_order.repaired">
            Vehiculo reparado
        </span>

        <!-- caso finalizado -->
        <span v-if="status === $page.props.status.repair_order.finalized">
            <i class="fas fa-check text-green-600"></i>
            Caso finalizado
        </span>
    </div>
</template>
