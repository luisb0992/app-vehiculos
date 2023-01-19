import { useForm } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import { hasCamera } from "@/Utils/Common/common";
import axios from "axios";
import  "@/Utils/Common/api";

export const filterModels = ref([]);
export const allColors = ref([]);
export const showModalBrand = ref(false);
export const showModalModel = ref(false);
export const showModalColor = ref(false);
export const showCamera = ref(false);

export const form = useForm({
    chassis_number: "",
    brand_id: "",
    model_id: "",
    color_id: "",
    gallery: [],
});

export const getModels = (models) => {
    const data = models.filter((model) => model.brand_id === form.brand_id);
    filterModels.value = data;
    form.model_id = "";
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

//get api vehicle
export const handleSearchVehicle = () => {
    axios.post('/api/formautos/consulta_vehiculo', { chassis_number: form.chassis_number })
    .then((response) => {
        console.log(response.data);
    });

    /* axios.post("https://jsonplaceholder.typicode.com/posts", post).then((result) => {
    console.log(result);
  }); */
}

export const saveVehicle = () => {
    form.post(route("vehicle.store"), {
        // onStart: () => console.log("start"),
        onError: (error) => console.log(error),
        onSuccess: (resp) => clearForm(),
        onFinish: (resp) => console.log(resp),
    });
};

/**
 * Filtrar los modelos por el buscador
 *
 * @param {String} event        // evento del buscador
 * @param {Array} models        // lista de modelos
 */
export const searchModels = (event, models) => {
    setTimeout(() => {
        if (!event.query.trim().length) {
            getModels(models);
            return;
        }

        // filtrar
        const text = event.query.toLowerCase();
        const fnFilter = (model) => model.name.toLowerCase().startsWith(text);
        filterModels.value = models.filter(fnFilter);
    }, 250);
};

/**
 * Filtrar los colores por el buscador
 *
 * @param {String} event        // evento del buscador
 * @param {Array} colors        // lista de colores
 */
export const searchColor = (event, colors) => {
    const query = event.query;

    setTimeout(() => {
        if (!query.trim().length) {
            allColors.value = colors;
            return;
        }

        // filtrar
        const text = query.toLowerCase();
        const fnFilter = (color) => color.name.toLowerCase().startsWith(text);
        allColors.value = colors.filter(fnFilter);
    }, 250);
};
