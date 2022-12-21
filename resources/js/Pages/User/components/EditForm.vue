<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";

import Checkbox from "@/Components/Checkbox.vue";

import {
    getRol,
    getWorkshop,
    handleUpdateUser,
    filterModels,
    clearForm
} from "../modules/edit";

const props = defineProps({
    roles: Array,
    workshops: Array,
    user : Object
});

const form = useForm({
    //checked para cambiar contraseña
    update_password: false,

    //data form
    rol_id: props.user.rol_id,
    workshop_id: props.user.workshop_id,
    name: props.user.name,
    last_name: props.user.last_name,
    email: props.user.email,
    dni: props.user.dni,
    password: "",
    password_confirmation: "",
});


</script>
<template>
    <form @submit.prevent="handleUpdateUser(form,props.user.id)">
        <div class="flex flex-col gap-5">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.name"
                    required
                    autofocus
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.name"
                />
            </div>

            <div>
                <InputLabel for="last_name" value="Apellido" />
                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.last_name"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.last_name"
                />
            </div>
            <div>
                <InputLabel for="dni" value="DNI" />
                <TextInput
                    id="dni"
                    type="text"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.dni"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.dni"
                />
            </div>
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.email"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.email"
                />
            </div>
            <div v-if="($page.props.auth.user.rol_id == 1)">
                <InputLabel for="rol" value="Rol" />
                <select
                    id="rol"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.rol_id"
                    required
                    @change="getRol(roles,form)"
                >
                    <option value="">Seleccione un rol</option>
                    <option
                        v-for="rol in roles"
                        :key="rol.id"
                        :value="rol.id"
                    >
                        {{ rol.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.rol_id" />
            </div>

            <div v-if="($page.props.auth.user.rol_id == 4 || form.rol_id == 4)">
                <InputLabel for="workshop" value="Taller" />
                <select
                    id="workshop"
                    class="mt-1 block w-full border-gray-200 border"
                    v-model="form.workshop_id"
                    :required="form.rol_id == 4"
                    @change="getWorkshop(workshops,form)"
                >
                    <option value="">Seleccione un taller</option>
                    <option
                        v-for="workshop in workshops"
                        :key="workshop.id"
                        :value="workshop.id"
                        :selected="form.workshop_id"
                    >
                        {{ workshop.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.workshop_id" />
            </div>
            <div>
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.update_password" />
                    <span class="ml-2 text-sm text-gray-600">¿Deseas Cambiar la contraseña de este usuario?</span>
                </label>
            </div>
            <div v-if="form.update_password">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full border-gray-200 border  animate-fade-in-down"
                    v-model="form.password"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password"
                />
            </div>
            <div v-if="form.update_password">
                <InputLabel for="password_confirmation" value="Repetir Contraseña" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full border-gray-200 border  animate-fade-in-down"
                    v-model="form.password_confirmation"
                    required
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex flex-col md:lg:flex-row gap-2">
                <PrimaryButton
                    class="w-full  flex justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    :type="form.processing ? 'button' : 'submit'"
                >
                    <span class="px-6 py-3 uppercase"> Guardar </span>
                </PrimaryButton>
                <SecondaryButton @click="clearForm(form)" class="w-full  flex justify-center">
                     <span class="px-6 py-3 uppercase"> Limpiar </span>
                </SecondaryButton>
            </div>
        </div>
    </form>
</template>
