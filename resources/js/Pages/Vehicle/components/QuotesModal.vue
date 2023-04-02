<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import InputText from "primevue/inputtext";
import { computed, ref, onMounted } from "vue";
import SpanStatusOrder from "./SpanStatusOrder.vue";
import { manageError } from "@/Utils/Common/common";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "3xl",
    },
    vehicle: {
        type: Object,
        default: {},
    },
});

// variables reactivas
const loading = ref(false);

const emit = defineEmits(["close"]);

const form = useForm({
    number: "",
    quotation_id: "",
    order_id: "",
    orders: [],
});

/**
 * Ordenes del vehiculo
 */
const orders = computed(() => props.vehicle.repair_orders);

/**
 * Mostrar o no el PDF de cotización según el status
 *
 * @param {Object} order        Orden de reparación
 */
const showPdf = (order) => {
    return (
        order.status === usePage().props.value.status.repair_order.quoted ||
        order.status === usePage().props.value.status.repair_order.approved ||
        order.status === usePage().props.value.status.repair_order.in_repair ||
        order.status === usePage().props.value.status.repair_order.repaired ||
        order.status === usePage().props.value.status.repair_order.finalized
    );
};

/**
 * Permitir aprobar o no la cotización
 *
 * @param {Object} order        Orden de reparación
 */
const allowApprove = (order) => {
    return order.status === usePage().props.value.status.repair_order.quoted;
};

/**
 * Verificar si todas las ordenes han sido reparadas
 */
const allRepaired = computed(() => {
    return orders   .value.every((order) => {
        return (
            order.status === usePage().props.value.status.repair_order.repaired
        );
    });
});

/**
 * Verificar si el vehiculo tiene estado finalizado
 */
const vehicleFinalized = computed(() => {
    return props.vehicle.status === usePage().props.value.status.vehicle.finalized;
});

/**
 * Aprobar o no la cotización
 */
const approveOrder = (order) => {
    if (!order.order_number || !order.quotation.id) {
        manageError({
            text: "Debe ingresar el número de orden de compra",
        });
        return;
    }

    loading.value = true;
    form.number = order.order_number;
    form.quotation_id = order.quotation.id;
    form.order_id = order.id;

    // enviar formulario
    form.post(route("workshop_quotes.approveQuotation"), {
        onError: (error) => manageError(),
        onSuccess: (resp) => emit("close"),
        onFinish: () => loading.value = false,
    });
};

/**
 * Finalizar el caso y actualizar el status del vehiculo
 */
const finalizedCase = () => {
    loading.value = true;
    form.orders = orders.value;
    form.post(route("workshop_quotes.finalizedCase"), {
        onError: (error) => manageError(),
        onSuccess: (resp) => emit("close"),
        onFinish: () => loading.value = false,
    });
};
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
            <div class="flex justify-end pb-3">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </div>
            <div class="w-full">
                <div class="flex flex-col md:flex-row  md:justify-between items-center">
                    <h1 class="uppercase text-zinc-900 font-bold pb-2">
                        Ordenes <span class="font-light">({{ vehicle.repair_orders_count }})</span>
                    </h1>
                    <h3 class="uppercase text-zinc-900 font-bold pb-2">
                        Nº Chasis: <span class="font-light">{{ vehicle.chassis_number }}</span>
                    </h3>
                </div>
                <hr />
                <div class="w-full pt-2 h-60 overflow-y-auto">
                    <div v-for="order in orders" class="mb-2">
                        <div
                            class="border border-turquesa p-3 rounded-md flex justify-between items-start"
                        >
                            <div>
                                <p>
                                    <span class="font-bold text-gray-900">
                                        Taller:
                                    </span>
                                    {{ order.workshop.name }}
                                </p>
                                <p>
                                    <span class="font-bold text-gray-900">
                                        Orden de reparación:
                                    </span>
                                    Nº {{ "000" + order.id }}
                                </p>
                                <p v-if="order.quotation?.invoice_number">
                                    <span class="font-bold text-gray-900">
                                        Nº de factura:
                                    </span>
                                    {{ order.quotation?.invoice_number }}
                                </p>
                                <p class="flex justify-start gap-3">
                                    <span class="font-bold text-gray-900">
                                        Status:
                                    </span>
                                    <SpanStatusOrder :order="order" />
                                </p>
                                <p v-if="allowApprove(order)" class="py-2">
                                    <button
                                        type="button"
                                        class="inline-flex items-center text-gray-900 bg-blue-400 hover:bg-blue-800 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150"
                                        @click.stop="order.showPurchaseOrder = true"
                                        v-if="!order.showPurchaseOrder"
                                    >
                                        <span class="font-medium text-sm">
                                            ¿Aprobar cotización?
                                        </span>
                                    </button>

                                    <div v-if="order.showPurchaseOrder" class="border border-turquesa p-3 rounded-lg animate-fade-in-down">
                                        <label :for="'order_number' + order.id" class="font-bold text-blue-800">
                                            Ingrese la orden de compra
                                        </label>
                                        <p>
                                            <InputText v-model="order.order_number" :id="'order_number' + order.id" required/>
                                        </p>

                                        <div class="py-2 flex gap-3">
                                            <button
                                                type="button"
                                                class="inline-flex items-center text-gray-900 bg-blue-400 hover:bg-blue-800 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150"
                                                :class="{
                                                    'opacity-50 cursor-not-allowed': !order.order_number || loading,
                                                }"
                                                @click.stop="approveOrder(order)"
                                                :disabled="!order.order_number || loading"
                                            >
                                                <span class="font-medium text-sm">
                                                    Aprobar
                                                </span>
                                            </button>
                                            <button
                                                type="button"
                                                class="inline-flex items-center text-gray-900 bg-red-400 hover:bg-red-800 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150"
                                                @click.stop="order.showPurchaseOrder = false"
                                                :disabled="loading"
                                            >
                                                <span class="font-medium text-sm">
                                                    Cancelar
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </p>
                            </div>
                            <div v-if="showPdf(order) && !order.showPurchaseOrder" class="flex flex-col gap-2">
                                <a
                                    :href="
                                        route(
                                            'workshop_quotes.downloadPDFQuote',
                                            order.quotation?.id
                                        )
                                    "
                                    class="rounded bg-red-300 hover:bg-red-400 inline-flex items-center gap-2 px-3 py-1.5"
                                    target="_blank"
                                    noopener="true"
                                    v-if="order.quotation?.id"
                                >
                                    <span class="text-gray-900 text-xs font-semibold">Cotización</span>
                                    <i
                                        class="fas fa-file-pdf text-red-600"
                                    ></i>
                                </a>
                                <a
                                    :href="$page.props.path.invoices.pp + order.quotation?.invoice_path"
                                    class="rounded bg-red-600 hover:bg-red-800 inline-flex items-center justify-between gap-2 px-3 py-1.5"
                                    target="_blank"
                                    noopener="true"
                                    :download="order.quotation?.invoice_path"
                                    v-if="order.quotation?.invoice_path"
                                >
                                    <span class="text-white text-xs font-semibold">Factura</span>
                                    <i class="fas fa-file-pdf text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full pt-2 flex justify-end" v-if="allRepaired && !vehicleFinalized">
                    <PrimaryButton
                        @click="finalizedCase"
                        type="button"
                        :class="{
                            'opacity-50 cursor-not-allowed': loading,
                        }"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition ease-in-out duration-150"
                        :disabled="loading"
                    >
                        Finalizar caso
                    </PrimaryButton>
                </div>
                <div class="w-full pt-2 flex justify-end" v-if="vehicleFinalized">
                    <div>
                        <p class="text-sm text-gray-500">
                            El caso ha sido finalizado
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-5">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                >
                    Cerrar
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
