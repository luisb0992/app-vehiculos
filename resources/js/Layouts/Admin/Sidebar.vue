<script setup>
import SideLink from "@/Components/Admin/Sidebar/SideLink.vue";

let Openbar = () => {
    const sidebar = document.querySelector(".sidebar");
    const submenu = document.querySelector("#submenu");
    const submenuWorkshop = document.querySelector("#submenuWorkshop");
    const submenuUtils = document.querySelector("#submenuUtils");
    sidebar.classList.toggle("left-0");
    sidebar.classList.toggle("left-[-300px]");
    submenu.classList.add("hidden");
    submenuWorkshop.classList.add("hidden");
    submenuUtils.classList.add("hidden");
};

let dropDown = () => {
    const submenu = document.querySelector("#submenu");
    const arrowVehicle = document.querySelector("#arrowVehicle");
    arrowVehicle.classList.toggle("rotate-0");
    submenu.classList.toggle("hidden");
};

const dropDownWorkshop = () => {
    const submenuWorkshop = document.querySelector("#submenuWorkshop");
    submenuWorkshop.classList.toggle("hidden");
    const arrowWorkshop = document.querySelector("#arrowWorkshop");
    arrowWorkshop.classList.toggle("rotate-0");
};

const dropDownUtils = () => {
    const submenuUtils = document.querySelector("#submenuUtils");
    submenuUtils.classList.toggle("hidden");
    const arrowUtils = document.querySelector("#arrowUtils");
    arrowUtils.classList.toggle("rotate-0");
};

const appName = globalThis.$appName;
const pathIcon = globalThis.$pathIcon;
</script>

<template>
    <span
        class="md:hidden lg:hidden fixed flex items-center justify-center z-10 text-white text-4xl inset-x-0 bottom-2 cursor-pointer"
        @click="Openbar()"
    >
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span>
    <div
        class="sidebar fixed min-h-screen top-0 bottom-0 lg:left-0 left-[-300px] md:left-0 z-10 duration-1000 p-2 w-[300px] overflow-y-auto text-center bg-gray-900 shadow h-full"
    >
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center rounded-md">
                <img :src="pathIcon" alt="icono" />
                <h1 class="text-[15px] ml-3 text-xl text-gray-200 font-bold">
                    {{ appName }}
                </h1>
                <i
                    class="bi bi-x ml-[8rem] cursor-pointer lg:hidden"
                    @click="Openbar()"
                ></i>
            </div>
            <h1 class="text-[15px] ml-3 text-md text-gray-200 font-bold mt-4">
                {{ $page.props.auth.user.name }}
            </h1>

            <hr class="my-2 text-gray-600" />
            <div>
                <SideLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    :icon="'bi bi-house-door-fill'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Inicio</span>
                </SideLink>
                <SideLink
                    :href="route('logs.index')"
                    :active="route().current('logs.*')"
                    :icon="'fa fa-list'"
                    v-if="$page.props.auth.user.rol_id == 1"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Bitácora</span>
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
                    <span class="text-[15px] ml-4 text-gray-200">Talleres</span>
                </SideLink>
                <!--  <SideLink
                    :href="route('roles.index')"
                    :active="route().current('roles.*')"
                    :icon="'bi bi-award-fill'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Roles</span>
                </SideLink> -->
                <SideLink
                    :href="route('reports.reports')"
                    :active="route().current('reports.reports')"
                    :icon="'pi pi-copy'"
                >
                    <span class="text-[15px] ml-4 text-gray-200">Reportes</span>
                </SideLink>
                <div
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer"
                >
                    <i class="fas fa-car"></i>
                    <div
                        class="flex justify-between w-full items-center"
                        @click="dropDown()"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Vehiculos
                        </span>
                        <span
                            class="text-sm rotate-180 transition duration-700"
                            id="arrowVehicle"
                        >
                            <i class="bi bi-arrow-down-square"></i>
                        </span>
                    </div>
                </div>
                <div
                    class="leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto"
                    id="submenu"
                    :class="{
                        visible: route().current('vehicle.*'),
                        hidden: !route().current('vehicle.*'),
                    }"
                >
                    <SideLink
                        :href="route('vehicle.create')"
                        :active="route().current('vehicle.create')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Crear
                        </span>
                    </SideLink>
                    <SideLink
                        :href="route('vehicle.index')"
                        :active="route().current('vehicle.index')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Listado
                        </span>
                    </SideLink>
                    <!-- <SideLink
                        :href="route('vehicle.reports')"
                        :active="route().current('vehicle.reports')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Reportes
                        </span>
                    </SideLink> -->
                </div>

                <!-- men y submenu cotizaciones -->
                <!-- <div
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer"
                >
                    <i class="fas fa-list-alt"></i>
                    <div
                        class="flex justify-between w-full items-center"
                        @click="dropDownWorkshop()"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Cotizaciones
                        </span>
                        <span
                            class="text-sm rotate-180 transition duration-700"
                            id="arrowWorkshop"
                        >
                            <i class="bi bi-arrow-down-square"></i>
                        </span>
                    </div>
                </div> -->
                <!-- <div
                    class="leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto"
                    id="submenuWorkshop"
                    :class="{
                        visible: route().current('workshop_quotes.*'),
                        hidden: !route().current('workshop_quotes.*'),
                    }"
                >
                    <SideLink
                        :href="route('workshop.create')"
                        :active="route().current('workshop.create')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Crear
                        </span>
                    </SideLink>
                    <SideLink
                        :href="route('workshop_quotes.index')"
                        :active="route().current('workshop_quotes.*')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Listado
                        </span>
                    </SideLink>
                </div> -->

                <div
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer"
                >
                    <i class="fas fa-wrench"></i>
                    <div
                        class="flex justify-between w-full items-center"
                        @click="dropDownUtils()"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Características
                        </span>
                        <span
                            class="text-sm rotate-180 transition duration-700"
                            id="arrowUtils"
                        >
                            <i class="bi bi-arrow-down-square"></i>
                        </span>
                    </div>
                </div>
                <div
                    class="leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto"
                    id="submenuUtils"
                    :class="{
                        visible: route().current('utils.*'),
                        hidden: !route().current('utils.*'),
                    }"
                >
                    <SideLink
                        :href="route('utils.colors.index')"
                        :active="route().current('utils.colors.*')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Colores
                        </span>
                    </SideLink>
                    <SideLink
                        :href="route('utils.models.index')"
                        :active="route().current('utils.models.*')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Modelos
                        </span>
                    </SideLink>
                    <SideLink
                        :href="route('utils.brands.index')"
                        :active="route().current('utils.brands.*')"
                        :icon="'bi bi-arrow-right-square'"
                        class="hover:bg-blue-600"
                    >
                        <span class="text-[15px] ml-4 text-gray-200">
                            Marcas
                        </span>
                    </SideLink>
                </div>

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
