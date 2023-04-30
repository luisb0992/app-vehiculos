<script setup>
import { manageError } from "@/Utils/Common/common";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import Swal from "sweetalert2/dist/sweetalert2";
import ButtonDownloadQuotation from "./ButtonDownloadQuotation.vue";
import ButtonDownloadInvoice from "./ButtonDownloadInvoice.vue";
import ButtonAddInvoice from "./ButtonAddInvoice.vue";
import AddInvoiceModal from "./AddInvoiceModal.vue";
import ButtonEditQuotation from "./ButtonEditQuotation.vue";

const props = defineProps({
    status: Number,
    id: Number,
    order: Object,
});

const showModalInvoice = ref(false);
const quotation_id = ref(0);

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

/**
 * Abrir modal para agregar factura
 */
const openModal = (id) => {
    showModalInvoice.value = true;
    quotation_id.value = id;
};
</script>
<template>
    <AddInvoiceModal
        :show="showModalInvoice"
        :quotation_id="quotation_id"
        :chassis_number="order.vehicle?.chassis_number"
        @close="showModalInvoice = false"
    />

    <div class="text-center w-4/5">
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
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                Reparación cotizada
            </p>

            <div class="flex flex-col justify-center items-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditQuotation :id="order.quotation.id" />
            </div>
        </div>

        <!-- aprobada -->
        <div v-if="status === $page.props.status.repair_order.approved">
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                Cotización aprobada
            </p>

            <div class="flex flex-col items-center justify-center">
                <button
                    class="hover:no-underline bg-purple-100 hover:bg-purple-300 text-purple-600 hover:text-purple-900 inline-flex items-center justify-center gap-2 px-3 py-2 w-full"
                    @click="startRepair"
                >
                    <i class="fas fa-arrow-right"></i>
                    <span class="text-xs font-semibold">
                        Iniciar reparación
                    </span>
                </button>
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal"
                    v-if="!order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- en repación -->
        <div v-if="status === $page.props.status.repair_order.in_repair">
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                En reparación
            </p>

            <div class="flex flex-col items-center justify-center">
                <button
                    class="hover:no-underline bg-yellow-100 hover:bg-yellow-300 text-yellow-600 hover:text-yellow-900 inline-flex items-center justify-center gap-2 px-3 py-2 w-full"
                    @click="finishRepair"
                >
                    <i class="fas fa-arrow-right"></i>
                    <span class="text-xs font-semibold"> Finalizar rep. </span>
                </button>
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal"
                    v-if="!order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- orden cancelada -->
        <div v-if="status === $page.props.status.repair_order.cancelLed">
            Orden cancelada
        </div>

        <!-- vehiculo reparado -->
        <div v-if="status === $page.props.status.repair_order.repaired">
            <p
                class="pb-2 mb-2 border-b-2 text-green-800 text-sm font-semibold"
            >
                Vehiculo reparado
            </p>

            <div class="flex flex-col items-center justify-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal"
                    v-if="!order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- caso finalizado -->
        <div v-if="status === $page.props.status.repair_order.finalized">
            <p
                class="pb-2 mb-2 border-b-2 text-green-800 text-sm font-semibold"
            >
                <i class="fas fa-check text-green-600"></i>
                Caso finalizado
            </p>

            <div class="flex flex-col items-center justify-center">
                <ButtonDownloadQuotation :id="order.quotation.id" />

                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal"
                    v-if="!order.quotation.invoice_path"
                />
            </div>
        </div>
    </div>
</template>
