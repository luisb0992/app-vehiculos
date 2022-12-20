import { useForm } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import { hasCamera } from "@/Utils/Common/common";

export const filterModels = ref([]);
export const showModalBrand = ref(false);
export const showModalModel = ref(false);
export const showModalColor = ref(false);
export const showCamera = ref(false);

export const form = useForm({
    chassis_number: "",
    brand_id: "",
    model_id: "",
    color_id: "",
    // status: 2, // no necesario
    gallery: [],
});

export const getModels = (models) => {
    const data = models.filter((model) => model.brand_id === form.brand_id);
    filterModels.value = data;
};

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = () => {
    form.reset("chassis_number", "");
    form.reset("brand_id", "");
    form.reset("model_id", "");
    form.reset("color_id", "");
    form.reset("gallery", []);
};

export const saveVehicle = () => {
    form.post(route("vehicle.store"), {
        // onStart: () => console.log("start"),
        onError: (error) => console.log(error),
        onSuccess: (resp) => clearForm(),
        onFinish: (resp) => console.log(resp),
    });
};

onMounted(() => {
    if (hasCamera.value) {
        showCamera.value = true;
    }
});
