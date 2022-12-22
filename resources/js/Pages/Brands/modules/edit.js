
export const clearForm = (form) => {
    form.name = "";
};

export const handleUpdate = (form,id) => {
    form.put(route("utils.brands.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
