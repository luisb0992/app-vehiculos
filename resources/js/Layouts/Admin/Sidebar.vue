<template lang="">
     <span class="md:hidden lg:hidden fixed flex items-center justify-center text-white text-4xl inset-x-0 bottom-2 cursor-pointer" @click="Openbar()">
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span>
    <div class="sidebar fixed top-0 bottom-0 lg:left-0 left-[-300px] z-10 duration-1000 p-2 w-[300px] overflow-y-auto text-center bg-gray-900 shadow h-screen">
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center rounded-md ">
                <i class="bi bi-app-indicator px-2 py-1 bg-blue-600 rounded-md"></i>
                <h1 class="text-[15px]  ml-3 text-xl text-gray-200 font-bold">Vehiculos</h1>
                <i class="bi bi-x ml-[8rem] cursor-pointer lg:hidden" @click="Openbar()"></i>
            </div>
            <h1 class="text-[15px]  ml-3 text-md text-gray-200 font-bold mt-4" >  {{ $page.props.auth.user.name }}</h1>

            <hr class="my-2 text-gray-600">
            <div>
                <SideLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    :icon="'bi bi-house-door-fill'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Inicio</span>
                </SideLink>
                <SideLink
                    :href="route('users.index')"
                    :active="route().current('users.*')"
                    :icon="'bi bi-people'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Usuarios</span>
                </SideLink>
                <SideLink
                    :href="route('workshops.index')"
                    :active="route().current('workshops.*')"
                    :icon="'fa-solid fa-screwdriver-wrench'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Taller</span>
                </SideLink>
                <SideLink
                    :href="route('roles.index')"
                    :active="route().current('roles.*')"
                    :icon="'bi bi-award-fill'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Roles</span>
                </SideLink>
                <div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer ">
                    <i class="bi bi-check-all"></i>
                    <div class="flex justify-between w-full items-center" @click="dropDown()">
                        <span class="text-[15px] ml-4 text-gray-200">Vehiculos</span>
                        <span class="text-sm rotate-180" id="arrow">
                        <i class="bi bi-arrow-down-square"></i>
                        </span>
                    </div>
                </div>
                <div class=" leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto" id="submenu">
                    <SideLink
                        :href="route('vehicle.create')"
                        :active="route().current('vehicle.create')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">Crear</span>
                    </SideLink>
                    <SideLink
                        :href="route('vehicle.index')"
                        :active="route().current('vehicle.index')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">Listado</span>
                    </SideLink>
                    <!-- <h1 class="cursor-pointer p-2 hover:bg-gray-700 rounded-md mt-1">Personal</h1>
                    <h1 class="cursor-pointer p-2 hover:bg-gray-700 rounded-md mt-1">Friends</h1> -->
                </div>
               <!--  <hr class="my-4 text-gray-600">
                <div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-blue-600">
                    <i class="bi bi-envelope-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Messages</span>
                </div> -->


                <!-- <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-blue-600">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Salir</span>
                </div> -->
                <SideLink
                    :href="route('logout')"
                    method="post"
                    :icon="'bi bi-box-arrow-in-right'"
                    as="button"
                    class="w-full"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Salir</span>
                </SideLink>
            </div>
        </div>
    </div>
</template>
<script setup>
import SideLink from "@/Components/Admin/Sidebar/SideLink.vue";

let Openbar = () => {
        const sidebar = document.querySelector(".sidebar");
        const arrow = document.querySelector("#arrow");
        const submenu = document.querySelector("#submenu");
        sidebar.classList.toggle("left-0");
        sidebar.classList.toggle("left-[-300px]");
        arrow.classList.toggle("rotate-180");
        submenu.classList.toggle("hidden");
    }

   let dropDown = () => {
        const submenu = document.querySelector("#submenu");
        submenu.classList.toggle("hidden");
    }
</script>
