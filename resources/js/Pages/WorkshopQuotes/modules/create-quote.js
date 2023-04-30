import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import { manageError } from "@/Utils/Common/common";
import Swal from "sweetalert2";

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
    const taxVal = includeTax.value ? tax.value : 0;
    const cal = (subtotal.value * taxVal) / 100;
    return parseFloat(subtotal.value + cal).toFixed(2);
});

/**
 * verificar si alguno de los cost esta en 0
 */
export const hasZero = computed(() => form.subs.some((sub) => sub.cost == 0));

/**
 * Guardar cotización
 *
 * @returns void
 */
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
    form.tax = includeTax.value ? tax.value : 0;
    form.total = parseFloat(total.value);

    form.post(route("workshop_quotes.storeQuote"), {
        onError: (error) => manageError(),
        onSuccess: (resp) => clearForm(),
    });
};

/**
 * Actualizar cotización
 *
 * @returns void
 */
export const updateQuote = (id) => {
    // validar que no haya un item con costo 0
    if (hasZero.value) {
        manageError({
            test: "No se puede actualizar la cotización si no ha llenado todos los items",
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
    form.tax = includeTax.value ? tax.value : 0;
    form.total = parseFloat(total.value);

    form.put(route("workshop_quotes.updateQuote", id), {
        onError: (error) => manageError(),
        onSuccess: (resp) => clearForm(),
    });
};

export const clearForm = () => {
    form.reset("subs", []);
    form.reset("subtotal", 0);
    form.reset("tax", 0);
    form.reset("total", 0);
    form.reset("repair_order_id", 0);
};

/**
 * Incluir o no impuesto
 */
export const includeTax = ref(false);

/**
 * Funcion que valida el formato del input
 * max 2 decimales y que no se pueda ingresar letras
 * ejemplo: 1.200,99
 *
 * @param {Input} e     Input del usuario
 */
export const validateFormat = (index) => {
    // const val = e.target.value;
    // console.log(val);
    const sub = form.subs[index];

    // regex que permita solo Numeros, punto y coma
    const regex = /([+-]?(?=\.\d|\d)(?:\d+)?(?:\.?\d*))(?:[eE]([+-]?\d+))?/i;

    // verifica si el valor cumple con la regex
    if (!regex.test(sub.cost)) {
        sub.cost = sub.cost.slice(0, -1);
        return;
    }

    // si hay punto
    const hasAPoint = sub.cost.indexOf(".") != -1;

    // si el usuario agrega un punto, comenzar a agregar los decimales
    if (hasAPoint) {
        // obtener los decimales agregados después del .
        let decimales = sub.cost.substring(sub.cost.indexOf(".") + 1);

        // si alcanza el limite de dígitos decimales, no permitir agregar mas
        if (decimales.length > 2) {
            // quitar el ultimo numero agregado
            const length = sub.cost.length - 1;
            sub.cost = sub.cost.substring(0, length);
        }
    }
};

// cargar y exportar los costos
export const loadCosts = (order) => {
    form.subs = [];
    form.repair_order_id = order.value.id;
    order.value.subcategories.forEach((sub) => {
        form.subs.push({
            id: sub.id,
            name: sub.name,
            cost: sub.pivot.cost,
        });
    });
};
