import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { manageError } from "@/Utils/Common/common";
import axios from "axios";
import Swal from "sweetalert2";

export const filterModels = ref([]);
export const allColors = ref([]);
export const showModalBrand = ref(false);
export const showModalModel = ref(false);
export const showModalColor = ref(false);
export const showCamera = ref(false);
export const loading = ref(false);

export const form = useForm({
    chassis_number: "",
    brand_id: "",
    model_id: "",
    color_id: "",
    company: "",
    gallery: [],
});

// limpiar los datos del formulario
// cuando se inicializa el componente
export const clearForm = () => {
    form.reset("chassis_number", "");
    form.reset("brand_id", "");
    form.reset("model_id", "");
    form.reset("color_id", "");
    form.reset("company", "");
    form.reset("gallery", []);
};

/**
 * Guardar el vehiculo
 */
export const saveVehicle = () => {
    form.post(route("vehicle.store"), {
        onError: (error) => console.log(error),
        onSuccess: (resp) => clearForm(),
        onFinish: (resp) => console.log(resp),
    });
};

/**
 * Buscar vehiculo en la api
 */
export const searchVehicle = () => {
    loading.value = true;
    const data = { chassis_number: form.chassis_number };
    axios
        .post(route("external_api.search.vehicle"), data)
        .then((resp) => {
            if (resp.status === 200) {
                const data = resp.data;
                form.color_id = data.vehiculo.auto.color;
                form.model_id = data.vehiculo.auto.modelo;
                form.brand_id = data.vehiculo.auto.marca;
                form.company = data.vehiculo.auto.compania;
            }

            if (resp.status === 204) {
                Swal.fire({
                    icon: "warning",
                    title: "Aviso!",
                    text: "Vehiculo no encontrado",
                });

                form.reset("brand_id", "");
                form.reset("model_id", "");
                form.reset("color_id", "");
                form.reset("company", "");
            }
        })
        .catch((err) => manageError())
        .finally(() => (loading.value = false));
};
