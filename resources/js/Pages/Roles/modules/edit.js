export const clearForm = (form) => {
    form.reset("name", "");
};

export const handleUpdateRol = (form,id) => {
    form.put(route("roles.update",id), {
        onStart: () => console.log("start"),
        onFinish: () => console.log("finish"),
        onError: (error) => console.log(error),
        onSuccess: () => clearForm(),
    });
};
