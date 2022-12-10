import { useForm,defineProps } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterModels = ref([]);

export const getRol = (models,form) => {
    const data = models.filter((model) => model.rol_id === form.rol_id);
    filterModels.value = data;
};

export const getWorkshop = (models,form) => {
    const data = models.filter((model) => model.taller_id === form.taller_id);
    filterModels.value = data;
};

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = (form) => {
    form.reset("rol_id", "");
    form.reset("workshop_id", "");
    form.reset("name", "");
    form.reset("last_name", "");
    form.reset("email", "");
    form.reset("dni", "");
};

export const handleUpdateUser = (form,id) => {
    form.put(route("users.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
