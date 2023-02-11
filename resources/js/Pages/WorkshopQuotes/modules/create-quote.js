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
    invoice_number: "",
    invoice: null,
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

export const clearForm = () => {
    form.reset("subs", []);
    form.reset("subtotal", 0);
    form.reset("tax", 0);
    form.reset("total", 0);
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

/**
 * Validar y cargar la factura
 * solo se permiten archivos pdf, txt, csv, docx, doc, xls, xlsx
 *
 * @param {File} e      Archivo seleccionado
 */
export const validateAndLoadInvoice = (e) => {
    const file = e.target.files[0];
    const allowedExtensions = /(\.pdf|\.txt|\.csv|\.docx|\.doc|\.xls|\.xlsx)$/i;

    if (!allowedExtensions.exec(file.name)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Solo se permiten archivos pdf, txt, csv, docx, doc, xls, xlsx",
        });

        // limpiar el input y el form
        e.target.value = "";
        form.reset("invoice", null);

        return;
    }

    form.invoice = file;
};
