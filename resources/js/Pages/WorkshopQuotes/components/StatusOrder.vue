<script setup>
import { manageError } from "@/Utils/Common/common";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2/dist/sweetalert2";
import ButtonDownloadQuotation from "./ButtonDownloadQuotation.vue";
import ButtonDownloadInvoice from "./ButtonDownloadInvoice.vue";

const props = defineProps({
    status: Number,
    id: Number,
    order: Object,
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
        <div v-if="status === $page.props.status.repair_order.open">
            <Link
                :href="route('workshop_quotes.createQuote', id)"
                class="hover:no-underline bg-blue-100 px-3 py-2 hover:bg-blue-300 text-blue-600 hover:text-blue-900 rounded-lg text-xs font-bold"
            >
                <i class="fas fa-arrow-right"></i>
                Cotizar ahora
            </Link>
        </div>

        <!-- cotizada -->
        <div v-if="status === $page.props.status.repair_order.quoted">
            <p class="pb-2">Reparación cotizada</p>

            <div class="flex flex-col gap-3 items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- aprobada -->
        <div v-if="status === $page.props.status.repair_order.approved">
            <p class="pb-2">Cotización aprobada</p>

            <div class="flex flex-col gap-3 items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <button
                    class="hover:no-underline bg-purple-100 px-3 py-2 hover:bg-purple-300 text-purple-600 hover:text-purple-900 rounded-lg text-xs font-bold"
                    @click="startRepair"
                >
                    <i class="fas fa-arrow-right"></i>
                    Iniciar reparación
                </button>
            </div>
        </div>

        <!-- en repació -->
        <div v-if="status === $page.props.status.repair_order.in_repair">
            <p class="pb-2">Vehiculo en reparación</p>

            <div class="flex flex-col gap-3 items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />

                <button
                    class="hover:no-underline bg-yellow-100 px-3 py-2 hover:bg-yellow-300 text-yellow-600 hover:text-yellow-900 rounded-lg text-xs font-bold"
                    @click="finishRepair"
                >
                    <i class="fas fa-arrow-right"></i>
                    Finalizar reparación
                </button>
            </div>
        </div>

        <!-- orden cancelada -->
        <div v-if="status === $page.props.status.repair_order.cancelLed">
            Orden cancelada
        </div>

        <!-- vehiculo reparado -->
        <div v-if="status === $page.props.status.repair_order.repaired">
            <p class="pb-2">Vehiculo reparado</p>

            <div class="flex flex-col gap-3 items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- caso finalizado -->
        <div v-if="status === $page.props.status.repair_order.finalized">
            <p class="pb-2">
                <i class="fas fa-check text-green-600"></i>
                Caso finalizado
            </p>

            <div class="flex flex-col gap-3 items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>
    </div>
</template>
