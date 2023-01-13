<template lang="">
    <Dialog header="Header" v-model:visible="open" :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}" :maximizable="true" :modal="true">
            <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <template #footer>
                <Button label="No" icon="pi pi-times" @click="closeMaximizable" class="p-button-text"/>
                <Button label="Yes" icon="pi pi-check" @click="closeMaximizable" autofocus />
            </template>
        </Dialog>
</template>
<script setup>
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import {ref} from 'vue'

const props = defineProps({
    displayMaximizable : Boolean
});

//alert(props.displayMaximizable);

const open = ref(props.displayMaximizable);

const closeMaximizable = () => {
            open.value = false;
        };

</script>
