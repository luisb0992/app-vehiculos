import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import { currentDate } from "@/Utils/Common/common";

export const form = useForm({
    vehicle_id: "",
    warranty: "",
    bills: "",
    dock: "",
    workshop_id: "",
    send_date: currentDate,
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

// filtrar las opciones de las subcategorias
const filterOptions = (item) => {
    return item.sub_ids.filter((subcat) => subcat.dock || subcat.warranty);
};

// agregar o eliminar una categoría, subcategoria y opciones
export const addOrRemoveToArray = (e, cat, sub, option, subName) => {
    const checked = e.target?.checked;
    const addSub = { sub_id: sub, sub_name: subName, [option]: true };
    const hasCat = form.categories.some((item) => item.cat_id === cat);

    // si esta chequeado, agregar
    if (checked) {
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
    }
};

// verificar en una propiedad computada
// si al menos selecciono una subcategoria
export const hasSubcategory = computed(() => {
    return form.categories.some((item) => item.sub_ids.length);
});

// obtener subcategorias que solo tienen garantia
// solo los ids y el name
export const warrantySubcategories = computed(() => {
    return form.categories
        .map((item) => {
            return item.sub_ids.filter((subcat) => subcat.warranty);
        })
        .flat();
});

// obtener subcategorias que solo tienen dock
// solo los ids y el name
export const dockSubcategories = computed(() => {
    return form.categories
        .map((item) => {
            return item.sub_ids.filter((subcat) => subcat.dock);
        })
        .flat();
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
    form.orders.push({
        workshop_id: form.workshop_id,
        send_date: form.send_date,
        subs: form.selectedOptions,
    });

    // una vez cargada la orden
    // eliminar las categorias agregadas
    // del array de categorias
    form.selectedOptions.forEach((sub) => {
        form.categories.map((item) => {
            const index = item.sub_ids.findIndex(
                (subcat) => subcat.sub_id === sub.sub_id
            );

            item.sub_ids.splice(index, 1);
        });
    });

    // agregar al backup de categorias
    // las categories seleccionadas
    form.selectedOptions.forEach((sub) => {
        catBackup.value.push(sub);
    });

    // vaciar el array de seleccionadas
    form.selectedOptions = [];
};

// verifica si puede crear la orden
export const canCreateOrder = computed(() => {
    // debe haber seleccionado un taller
    // una fecha de envió
    // y al menos una subcategoria
    return (
        form.workshop_id &&
        form.send_date &&
        form.selectedOptions.length &&
        form.selectedOptions.some((sub) => sub.warranty || sub.dock)
    );
});

// obtener el nombre del taller
export const getWorkshopName = (workshops, id) => {
    return (
        workshops.find((item) => item.id === id)?.name || "Taller sin nombre"
    );
};
