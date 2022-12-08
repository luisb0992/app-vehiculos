import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterModels = ref([]);

export const form = useForm({
    rol_id: "",
    workshop_id: "",
    name: "",
    last_name: "",
    email: "",
    dni: "",
    password: "",
    password_confirmation: "",
});

export const getRol = (models) => {
    const data = models.filter((model) => model.rol_id === form.rol_id);
    filterModels.value = data;
};

export const getWorkshop = (models) => {
    const data = models.filter((model) => model.taller_id === form.taller_id);
    filterModels.value = data;
};

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = () => {
    form.reset("rol_id", "");
    form.reset("workshop_id", "");
    form.reset("name", "");
    form.reset("last_name", "");
    form.reset("email", "");
    form.reset("dni", "");
    form.reset("password", "");
    form.reset("password_confirmation", "");
};

export const handleSaveUser = () => {
    form.post(route("users.store"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
