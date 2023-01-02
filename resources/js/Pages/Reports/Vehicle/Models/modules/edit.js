import { ref } from "vue";

export const filterBrands = ref([]);

export const getBrands = (brands,form) => {
    const data = brands.filter((brand) => brand.brand_id === form.brand_id);
    filterBrands.value = data;
};
export const clearForm = (form) => {
    form.name = "";
    form.brand_id = null;
};

export const handleUpdate = (form,id) => {
    form.put(route("utils.models.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
