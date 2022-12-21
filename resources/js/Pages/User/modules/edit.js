import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterModels = ref([]);


export const getRol = (models,form) => {
    const data = models.filter((model) => model.rol_id === form.rol_id);
    filterModels.value = data;
    if(form.rol_id != 4){
        form.workshop_id = "";
    }
};

export const getWorkshop = (models,form) => {
    const data = models.filter((model) => model.taller_id === form.taller_id);
    filterModels.value = data;
};

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = (form) => {
    console.log(form.update_password)
    form.rol_id = "";
    form.workshop_id = "";
    form.name = "";
    form.last_name = "";
    form.email = "";
    form.dni = "";
    form.update_password = false;

};

export const handleUpdateUser = (form,id) => {
    form.put(route("users.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
