<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Banner from "@/Components/Banner.vue";

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login.auth"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div
            class="max-w-7xl min-h-[600px] bg-white shadow-md overflow-hidden rounded-lg mx-auto"
        >
            <div class="flex flex-wrap justify-between items-center">
                <div class="w-full lg:w-1/2 h-[600px] lg:block hidden">
                    <div class="flex justify-center items-center h-full">
                        <Banner
                            class="block w-80 h-60 text-gray-800 aspect-video rounded-lg"
                        />
                    </div>
                </div>
                <div
                    class="w-full lg:w-1/2 bg-gray-900 h-[600px] lg:rounded-l-3xl"
                >
                    <div
                        class="flex justify-center items-center min-w-full min-h-full"
                    >
                        <form @submit.prevent="submit" class="w-full px-10">
                            <Banner
                                class="block w-full h-40 text-gray-800 aspect-video rounded-lg lg:hidden mb-7"
                            />
                            <div>
                                <InputLabel
                                    class="text-gray-50"
                                    for="email"
                                    value="Email"
                                />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />

                                <InputError
                                    class="mt-2 text-gray-50"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel
                                    class="text-gray-50"
                                    for="password"
                                    value="Contraseña"
                                />

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                />

                                <InputError
                                    class="mt-2 text-gray-50"
                                    :message="form.errors.password"
                                />
                            </div>

                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        name="remember"
                                        v-model:checked="form.remember"
                                    />
                                    <span class="ml-2 text-sm text-gray-50">
                                        Recordar
                                    </span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <!-- <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                    ¿Olvidaste tu contraseña?
                    </Link> -->

                                <PrimaryButton
                                    class="ml-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Entrar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
