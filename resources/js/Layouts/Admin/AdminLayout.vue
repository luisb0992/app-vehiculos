<template>
    <SideBar />

    <div class="main-content relative flex flex-col flex-grow md:pl-[300px]">
        <NavBar />
        <!-- <h1 class="font-bold text-2xl text-gray-700">Inicio</h1> -->
        <div class="flex flex-col flex-grow bg-white rounded mt-4">
            <!-- mostrar mensaje -->
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <AlertDismiss
                    :show-success="$page.props.flash.success ? true : false"
                    :show-danger="$page.props.flash.error ? true : false"
                />
            </div>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import SideBar from "@/Layouts/Admin/Sidebar.vue";
import NavBar from "@/Layouts/NavBar.vue";
import AlertDismiss from "@/Components/AlertDismiss.vue";
</script>
