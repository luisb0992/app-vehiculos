import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import Swal from "sweetalert2";
import { currentDate, currentDateTime } from "@/Utils/Common/common";

export const form = useForm({
    // cargar el id del vehículo desde el parámetro recibido
    vehicle_id: "",

    // iniciar en la fecha actual, format MM-DD-YYYY
    send_date: currentDateTime.value,
    categories: [],

    // garantia y dock seleccionados
    selectedOptions: [],

    // resultado final de la selección
    // indica el taller a los que deben ir
    // cada selección
    orders: [],
});

// backup de categorias
export const catBackup = ref([]);

// continuar con el registro de la reparación
export const continueRepair = ref(false);

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = () => {
    form.reset("vehicle_id", "");
    form.reset("send_date", "");
    form.reset("categories", []);
    form.reset("selectedOptions", []);
    form.reset("orders", []);
    continueRepair.value = false;
};

// formulario de reparación
export const saveRepair = () => {
    form.post(route("vehicle.store.repair"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: (resp) => clearForm(),
    });
};

// activar o desactivar el botón de finalizar
export const canFinish = computed(() => {
    return form.processing || hasSubToAssign.value || !form.orders.length;
});

// obtener el nombre del taller
export const getWorkshopName = (workshops, id) => {
    return (
        workshops.find((item) => item.id === id)?.name || "Taller sin nombre"
    );
};

// filtrar las opciones de las subcategorias
const filterOptions = (item) => {
    return item.sub_ids.filter((subcat) => subcat.dock || subcat.warranty);
};

// verifica si puede crear la orden
export const canCreateOrder = computed(() => {
    return (
        form.selectedOptions.length &&
        form.selectedOptions.some((sub) => sub.warranty || sub.dock)
    );
});

// agregar o eliminar una categoría, subcategoria y opciones
export const addOrRemoveToArray = (e, cat, sub, option, subName, object) => {
    const checked = e.target?.checked;
    const addSub = { sub_id: sub, sub_name: subName, [option]: true };
    const hasCat = form.categories.some((item) => item.cat_id === cat);
    const sub_cat = object;

    // si esta chequeado, agregar
    if (checked) {
        if (option == "warranty") {
            sub_cat.disabledDock = true;
        }

        if (option == "dock") {
            sub_cat.disabledWarranty = true;
        }
        if (hasCat) {
            form.categories.map((item) => {
                if (item.cat_id === cat) {
                    const hasSub = item.sub_ids.some(
                        (subcat) => subcat.sub_id === sub
                    );

                    if (hasSub) {
                        item.sub_ids.map((subcat) => {
                            if (subcat.sub_id === sub) {
                                subcat[option] = true;
                            }
                        });
                    } else {
                        item.sub_ids.push(addSub);
                    }
                }
            });
            return;
        }

        form.categories.push({ cat_id: cat, sub_ids: [addSub] });
    }

    // si no esta chequeado, eliminar
    if (!checked) {
        if (hasCat) {
            form.categories.map((item) => {
                if (item.cat_id === cat) {
                    const hasSub = item.sub_ids.some(
                        (subcat) => subcat.sub_id === sub
                    );

                    if (hasSub) {
                        item.sub_ids.map((subcat) => {
                            if (subcat.sub_id === sub) {
                                subcat[option] = false;
                            }
                        });
                    }
                }
            });
        }

        // si dock y warranty son false, se elimina la subcategoria
        form.categories.map((item) => (item.sub_ids = filterOptions(item)));
        form.categories = form.categories.filter((item) => item.sub_ids.length);

        if (option == "warranty") {
            sub_cat.disabledDock = false;
        }

        if (option == "dock") {
            sub_cat.disabledWarranty = false;
        }
    }
};

// verificar en una propiedad computada
// si al menos selecciono una subcategoria
export const hasSubcategory = computed(() => {
    return form.categories.some((item) => item.sub_ids.length);
});

// array de subcategorias con garantia
export const warrantySubcategories = computed(() => {
    const data = form.categories.map((item) => {
        return item.sub_ids.filter((subcat) => subcat.warranty);
    });

    // eliminar los duplicados
    return data.flat().filter((item, index, self) => {
        return (
            index ===
            self.findIndex(
                (t) => t.sub_id === item.sub_id && t.sub_name === item.sub_name
            )
        );
    });
});

// array de subcategorias con dock
export const dockSubcategories = computed(() => {
    const data = form.categories.map((item) => {
        return item.sub_ids.filter((subcat) => subcat.dock);
    });

    // eliminar los duplicados
    return data.flat().filter((item, index, self) => {
        return (
            index ===
            self.findIndex(
                (t) => t.sub_id === item.sub_id && t.sub_name === item.sub_name
            )
        );
    });
});

// verificar si hay subcategorias aun por asignar
// a un taller
export const hasSubToAssign = computed(() => {
    return warrantySubcategories.value.length || dockSubcategories.value.length;
});

// si el usuario a seleccionado algunos de loc checks
// de garantia o dock, se activa el select de taller
export const canSendWorkshop = computed(() => {
    return form.selectedOptions.length;
});

// si se marco algunas de las seleccionadas
// agregar o eliminar del array
export const addOrRemoveOption = (e, subID, subName, option) => {
    const addSub = { sub_id: subID, sub_name: subName, [option]: true };
    const checked = e.target?.checked;

    if (checked) {
        form.selectedOptions.push(addSub);
    }

    if (!checked) {
        // encontrar index
        const index = form.selectedOptions.findIndex(
            (item) => item.sub_id === subID
        );

        // eliminar
        form.selectedOptions.splice(index, 1);
    }
};

// cargar la orden con las sub categorias
// seleccionadas
export const loadOrder = () => {
    // validar
    if (!form.send_date || !form.workshop_id || !form.selectedOptions.length) {
        Swal.fire({
            icon: "error",
            title: "Aviso",
            text: "Debe seleccionar una fecha de envío y un taller",
        });
        return;
    }

    form.orders.push({
        workshop_id: form.workshop_id,
        send_date: form.send_date,
        subs: form.selectedOptions,
    });

    // una vez agregada la orden
    // eliminar las subcategorias que coincidan
    // con las seleccionadas
    form.selectedOptions.forEach((obj) => {
        form.categories.forEach((item) => {
            const subID = obj.sub_id;
            const array = item.sub_ids;

            // eliminar donde coincida el id
            item.sub_ids = array.filter((subcat) => subcat.sub_id !== subID);
        });
    });

    // vaciar el array de seleccionadas
    form.selectedOptions = [];

    // devolver el select de opciones a su estado inicial
    form.workshop_id = "";
};

// elimina la orden y vuelve a agregar
// las sub categorias a las opciones seleccionadas anteriormente
// selectedOptions es un array de objetos
// { sub_id: 1, sub_name: 'nombre', warranty: true, dock: false }
export const deleteOrder = (index) => {
    // obtener las sub categorias de la orden
    const order = form.orders[index];
    const subs = order.subs;

    // agregar las sub categorias a las categorias anteriores
    subs.forEach((sub) => {
        form.categories.map((obj) => {
            obj.sub_ids.push(sub);
        });
    });

    // eliminar la orden
    form.orders.splice(index, 1);
};
