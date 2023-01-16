<template lang="">
    <Dialog :header="'Vehiculo - '+vehicle.chassis_number " :closable="false" :visible="show" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :maximizable="true" :modal="true">
        <div class="flex justify-between mt-4 bg-blue-100 border-b-2 border-blue-300 p-2">
            <span class="font-bold text-md uppercase">Nro Chasis</span>
            <span class="font-medium text-md">{{ vehicle.chassis_number }}</span>
        </div>
        <div class="flex justify-between mt-1 bg-blue-100 border-b-2 border-blue-300 p-2">
            <span class="font-bold text-md uppercase">Marca</span>
            <span class="font-medium text-md">{{ vehicle.brand }}</span>
        </div>
        <div class="flex justify-between mt-1 bg-blue-100 border-b-2 border-blue-300 p-2">
            <span class="font-bold text-md uppercase">Modelo</span>
            <span class="font-medium text-md">{{ vehicle.model }}</span>
        </div>
        <div class="flex justify-between mt-1 bg-blue-100 border-b-2 border-blue-300 p-2">
            <span class="font-bold text-md uppercase">Color</span>
            <span class="font-medium text-md">{{ vehicle.color }}</span>
        </div>
        <h2 class="py-4 text-3xl font-bold text-center text-black">
            Ordenes
        </h2>
        <div class="flex justify-center items-center" v-if="vehicle.repair_orders.length <= 0">
            <span>No hay solicitud de reparaciones creadas </span>
        </div>
        <div class="relative overflow-x-auto" v-if="vehicle.repair_orders.length > 0">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-lg text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Taller
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sub Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IVA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in vehicle.repair_orders" :key="order.id" class="bg-white border-b ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{order.workshop}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{order.status}}
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{order.date}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            ${{order.subtotal}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            ${{order.iva}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            ${{order.total}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="py-4 text-3xl font-bold text-center text-black">
            Fotos
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 p-1">
            <div class="w-full" v-for="photo in vehicle.photos" :key="photo.id">
                <img :src="
                pp.resizeImgVehicle.value +
                photo.path
<<<<<<< HEAD
            " alt="image"
            @click.stop="openImage(photo.path)" />
=======
            " alt="image" class="w-full h-full" />
>>>>>>> 8df1498490d16b4141299ffc9f6238ced7acec66
            </div>
        </div>
        <template #footer>
            <Button label="Cerrar" icon="pi pi-times" @click="$emit('close')" class="p-button-text"/>
        </template>
    </Dialog>
    <Dialog header="Header"  :modal="true" v-model:visible="displayBasic" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :position="'bottom'">
            <img
                :src="imgPath(image)"
                class="w-full h-full object-cover object-center rounded"
            />
    </Dialog>
</template>
<script setup>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import {ref,defineEmits} from 'vue'
import { pp } from "@/Utils/Common/common";


const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    vehicle: {
        type: Object,
        default: {},
    },
});

const displayBasic = ref(false);
const showModal = ref(false);
const image = ref({});

const openImage = (img = null) => {
    const firstImage = props.vehicle?.photos[0];
    image.value = !img ? firstImage : img;
    showModal.value = true;
    displayBasic.value = true;
};

const imgPath = (path) => {
    if (path) {
        return pp.resizeImgVehicle.value + path;
    }
    return "/";
};

const emits = defineEmits(['close']);

</script>
