import { useForm } from "@inertiajs/inertia-vue3";

export const form = useForm({
    name: "",
});

export const clearForm = () => {
    form.reset("name", "");
};


export const handleSaveWorkshop = () => {
    form.post(route("workshops.store"), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
