import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterModels = ref([]);

export const form = useForm({
    chassis_number: "",
    brand_id: "",
    model_id: "",
    color_id: "",
    year: "",
    mileage: "",
    price: "",
    description: "",
    observation: "",
    status: 1,
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
    form.reset("year", "");
    form.reset("mileage", "");
    form.reset("price", "");
    form.reset("description", "");
    form.reset("observation", "");
    form.reset("status", 1);
    form.reset("gallery", []);
};

export const saveVehicle = () => {
    form.post(route("vehicle.store"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm,
    });
};
