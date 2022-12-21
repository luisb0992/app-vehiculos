import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const filterBrands = ref([]);
export const form = useForm({
    name: "",
    brand_id: "",
});

export const getBrands = (brands) => {
    const data = brands.filter((brand) => brand.brand_id === form.brand_id);
    filterBrands.value = data;
};

export const clearForm = () => {
    form.reset("name", "");
    form.reset("brand_id", "");
};


export const handleSave = () => {
    form.post(route("utils.models.store"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
