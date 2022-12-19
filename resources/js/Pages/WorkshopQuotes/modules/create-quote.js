import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import Swal from "sweetalert2";

export const form = useForm({
    subs: [],
    subtotal: 0,
    tax: 0,
    total: 0,
    repair_order_id: 0,
});

export const tax = ref(7);
export const taxString = computed(() => `${tax.value}%`);
export const subtotal = computed(() =>
    form.subs.reduce((acc, sub) => acc + sub.cost, 0)
);
export const total = computed(
    () => subtotal.value + (subtotal.value * tax.value) / 100
);

// verificar si alguno de los cost esta en 0
export const hasZero = computed(() => form.subs.some((sub) => sub.cost == 0));

export const saveQuote = () => {
    // validar que no haya un item con costo 0
    if (hasZero.value) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No se puede guardar una cotización si no ha llenado todos los items",
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

    form.subtotal = subtotal.value;
    form.tax = tax.value;
    form.total = total.value;

    form.post(route("workshop_quotes.storeQuote"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
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
