import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import Swal from "sweetalert2";
import { manageError } from "@/Utils/Common/common";

/**
 * Formulario
 */
export const form = useForm({
    subs: [],
    subtotal: 0,
    tax: 0,
    total: 0,
    repair_order_id: 0,
});

/**
 * Iva default 7%
 */
export const tax = ref(7);
export const taxString = computed(() => `${tax.value}%`);

/**
 * subtotal
 */
export const subtotal = computed(() => {
    return form.subs.reduce((total, sub) => {
        const cost = parseFloat(sub.cost);
        const acc = parseFloat(total);
        const sum = acc + cost;
        return isNaN(sum) ? 0 : sum;
    }, 0);
});

/**
 * Total
 */
export const total = computed(() => {
    const taxValue = (subtotal.value * tax.value) / 100;
    return parseFloat(subtotal.value + taxValue).toFixed(2);
});

/**
 * verificar si alguno de los cost esta en 0
 */
export const hasZero = computed(() => form.subs.some((sub) => sub.cost == 0));

export const saveQuote = () => {
    // validar que no haya un item con costo 0
    if (hasZero.value) {
        manageError({
            test: "No se puede guardar una cotización si no ha llenado todos los items",
        });
        return;
    }

    // validar total y subtotal
    if (subtotal.value == 0 || total.value == 0) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "El total y subtotal debe ser mayor a 0",
        });
        return;
    }

    form.subtotal = parseFloat(subtotal.value);
    form.tax = tax.value;
    form.total = parseFloat(total.value);

    form.post(route("workshop_quotes.storeQuote"), {
        onError: (error) => manageError(),
        onSuccess: (resp) => clearForm(),
    });
};

export const clearForm = () => {
    form.reset("subs", []);
    form.reset("subtotal", 0);
    form.reset("tax", 0);
    form.reset("total", 0);
    form.reset("total", 0);
    form.reset("repair_order_id", 0);
};
