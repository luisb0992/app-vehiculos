<script setup>
import { ref } from "vue";
import { form } from "../modules/create";
import { hasCamera } from "@/Utils/Common/common";

const result = document.querySelector("#screenshot-result");
const video = document.querySelector("video");
const canvas = document.querySelector("canvas");

// config para la cámara
const CONSTRAINTS = {
    video: {
        width: {
            min: 1280,
            ideal: 1920,
            max: 2560,
        },
        height: {
            min: 720,
            ideal: 1080,
            max: 1440,
        },
        facingMode: "environment", // cámara trasera
        // facingMode: 'user', // cámara frontal
    },
};

// variables
const init = ref(false);
const stop = ref(false);
const capture = ref(false);

const initCamera = () => {
    // iniciar la cámara
    navigator.mediaDevices
        .getUserMedia(CONSTRAINTS)
        .then((stream) => {
            // mostrar la cámara en el video
            video.srcObject = stream;
            video.play();

            init.value = true;
            stop.value = false;
        })
        .catch((err) => {
            console.log(err);
            init.value = false;
            stop.value = true;
        });
};

const cancelCamera = () => {
    // detener la cámara
    const stream = video.srcObject;
    const tracks = stream.getTracks();
    tracks.forEach((track) => {
        track.stop();
    });
    video.srcObject = null;

    init.value = false;
    stop.value = true;
};

const captureImage = () => {
    // capturar la imagen
    const context = canvas.getContext("2d");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // mostrar la imagen
    result.src = canvas.toDataURL("image/png");

    // agregar la imagen al array de imágenes
    form.gallery.push(canvas.toDataURL("image/png"));

    // detener la cámara
    cancelCamera();
};
</script>
<template>
    <h3 class="font-medium text-lg text-gray-900" v-if="!hasCamera">
        Parece que tu dispositivo no tiene cámara integrada o disponible
        <p class="text-base text-gray-500">
            Intenta subir los archivos desde tu dispositivo
        </p>
    </h3>
    <div class="flex flex-col justify-center items-center border" v-else>
        <video v-show="init"></video>
        <canvas v-show="!init && stop"></canvas>

        <div class="w-80 h-80 border-4">
            <img
                class="w-full h-full object-center object-none"
                alt="result-camera"
                id="screenshot-result"
            />
        </div>

        <div>
            <button
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                @click.stop="initCamera"
                v-if="!init"
            >
                Iniciar
            </button>
            <button
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                @click.stop="cancelCamera"
                v-if="init"
            >
                Cancelar
            </button>
            <button
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                @click.stop="captureImage"
                v-if="init"
            >
                Tomar foto
            </button>
        </div>
    </div>
</template>
