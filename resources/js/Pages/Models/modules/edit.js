
export const clearForm = (form) => {
    form.reset("name", "");
    form.reset("brand_id", "");
};

export const handleUpdate = (form,id) => {
    form.put(route("utils.models.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
