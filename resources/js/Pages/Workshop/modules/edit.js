
export const clearForm = (form) => {
    form.name = "";
};

export const handleUpdateWorkshop = (form,id) => {
    form.put(route("workshops.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(form),
    });
};
