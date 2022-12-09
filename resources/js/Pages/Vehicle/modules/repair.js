import { useForm } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";

export const form = useForm({
    vehicle_id: "",
    warranty: "",
    bills: "",
    dock: "",
    workshop_id: "",
    send_date: "",
    categories: [],
});

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
export const addOrRemoveToArray = (e, cat, sub, option) => {
    const checked = e.target?.checked;
    const addSub = { sub_id: sub, [option]: true };
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
