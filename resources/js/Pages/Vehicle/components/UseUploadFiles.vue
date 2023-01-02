<script setup>
import { useGalleryStore } from "@/Store/gallery";
import Swal from "sweetalert2";

const galleryStore = useGalleryStore();

// formatos de archivos permitidos
const ALLOWED_FORMATS = ["image/png", "image/jpeg", "image/jpg"];

// cargar los archivos en la propiedad y mostrar preview
const loadFiles = (e) => {
    const files = e.target.files;
    let errors = [];

    // recorrer los archivos
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // validar el formato del archivo
        if (!ALLOWED_FORMATS.includes(file.type)) {
            errors.push(
                `El archivo ${
                    file.name
                } no es una imagen válida. Formatos permitidos: ${ALLOWED_FORMATS.join(
                    ", "
                )}`
            );
        }

        // errors
        if (errors.length) {
            e.target.value = null;
            Swal.fire({
                title: "Error",
                text: errors.join(""),
                icon: "error",
            });
            return;
        }

        // agregar el archivo al array de archivos
        galleryStore.addImage(file);
    }
};
</script>
<template>
    <div class="bg-gray-100 px-2 rounded">
        <div class="py-5">
            <label class="block">
                <span class="sr-only">Seleccionar archivos o tomar fotos</span>
                <input
                    type="file"
                    accept="image/png, image/jpeg, image/jpg"
                    multiple
                    @change="loadFiles"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-300"
                    id="input-file"
                />
            </label>

            <!-- preview imagenes -->
            <div class="flex flex-wrap pt-5" v-if="galleryStore.hasImages()">
                <div
                    v-for="(image, index) in galleryStore.getPreviewImages()"
                    :key="index"
                    class="w-1/2 sm:w-1/3 p-2 relative"
                >
                    <img
                        :src="image"
                        class="w-full object-cover object-center aspect-square rounded"
                    />

                    <!-- botón de eliminar -->
                    <button
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex justify-center items-center"
                        @click="galleryStore.removeImage(index)"
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
        </div>
    </div>
</template>
