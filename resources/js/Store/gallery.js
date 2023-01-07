/**
 * Construir archivo store de pinia
 * para gestionar el estado de las imagenes del vehículo
 * al momento de ser seleccionadas
 */

import { defineStore } from "pinia";
import Swal from "sweetalert2";

export const useGalleryStore = defineStore("gallery", {
    state: () => ({
        images: [],
    }),
    actions: {
        // agregar imagen al array de imagenes
        // convertir imagen a base64
        addImage(image) {
            const reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = () => {
                this.images.push({
                    id: image.id,
                    name: image.name,
                    size: image.size,
                    type: image.type,
                    base64: reader.result,
                });
            };
        },

        // eliminar imagen del array de imagenes
        removeImage(index) {
            this.images.splice(index, 1);

            if (!this.hasImages()) {
                const input = document.getElementById("input-file");
                input.value = "";
            }
        },

        // limpiar array de imagenes
        clearImages() {
            this.images = [];
        },

        // obtener array de imagenes
        // convertir base64 a file todas las imagenes
        getImages() {
            const images = this.images.map((image) => {
                const file = this.dataURLtoFile(image.base64, image.name);
                return file;
            });

            return images;
        },

        // url to file
        dataURLtoFile(dataurl, filename) {
            if (!dataurl) return null;

            const arr = dataurl.split(",");
            const mime = arr[0].match(/:(.*?);/)[1];
            const bstr = atob(arr[1]);
            let n = bstr.length;
            const u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, { type: mime });
        },

        // clear session storage
        clearSessionStorage() {
            sessionStorage.removeItem("gallery");
        },

        // verificar si hay imagenes en el array
        hasImages() {
            return this.images.length > 0;
        },

        // devuelve las imagenes para mostrar la preview
        getPreviewImages() {
            return this.images.map((image) => {
                const file = this.dataURLtoFile(image.base64, image.name);
                return URL.createObjectURL(file);
            });
        },
    },
    // persist: {
    //     paths: ["images"],
    //     storage: sessionStorage,
    // },
});
