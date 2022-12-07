<script setup>
import { ref, inject } from "vue";
import { form } from "../modules/create";
// import { swal } from "@/Utils/Helpers/alerts";

// formatos de archivos permitidos
const ALLOWED_FORMATS = ["image/png", "image/jpeg", "image/jpg"];

// variables
const images = ref([]);
const swal = inject("$swal");

// cargar los archivos en la propiedad y mostrar preview
const loadFiles = (e) => {
    const files = e.target.files;

    // recorrer los archivos
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // validar el formato del archivo
        if (!ALLOWED_FORMATS.includes(file.type)) {
            swal({
                icon: "error",
                title: "Aviso!",
                text: "Ha seleccionado un formato de archivo no permitido",
            });

            // eliminar el archivo del input
            e.target.value = null;
            continue;
        }

        // agregar y mostrar la preview
        const preview = URL.createObjectURL(file);
        images.value.push(preview);

        // agregar el archivo al array de archivos
        form.gallery.push(file);
    }
};

const deleteImage = (index) => {
    // eliminar la imagen del array de imágenes
    images.value.splice(index, 1);

    // eliminar el archivo del array de archivos
    form.gallery.splice(index, 1);

    // si se eliminaron todos los archivos, limpiar el input
    if (!form.gallery.length) {
        document.querySelector("input[type=file]").value = null;
    }
};
</script>
<template>
    <div class="">
        <h3 class="font-medium text-lg text-gray-900">
            Parece que tu dispositivo no tiene cámara integrada o disponible
            <p class="text-base text-gray-500">
                Intenta subir los archivos desde tu dispositivo
            </p>
        </h3>
        <div class="py-5">
            <input
                type="file"
                accept="image/png, image/jpeg, image/jpg"
                multiple
                @change="loadFiles"
                class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
            />

            <!-- preview imagenes -->
            <div class="flex flex-wrap pt-5" v-if="images.length">
                <div
                    v-for="(image, index) in images"
                    :key="index"
                    class="w-1/2 p-2 relative"
                >
                    <img
                        :src="image"
                        class="w-full h-40 object-cover object-center"
                    />

                    <!-- botón de eliminar -->
                    <button
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex justify-center items-center"
                        @click="deleteImage(index)"
                        type="button"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <progress
                v-if="form.progress"
                :value="form.progress.percentage"
                max="100"
            >
                {{ form.progress.percentage }}%
            </progress>
        </div>
    </div>
</template>
