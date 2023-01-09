import "./bootstrap";
import "../css/app.css";

// assets glob
import.meta.glob(["../img/**"]);

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

// sweetalert2
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

//primeVue
import PrimeVue from "primevue/config";
import "primevue/resources/themes/tailwind-light/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";

// fontawesome core, componente y estilos
import "@/Utils/config/font-awesome";

//datepicker
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

// app name
const searchTag = globalThis.document.getElementsByTagName("title");
const appName = searchTag[0]?.innerText || "App vehículos";
globalThis.$appName = appName;

// banner
const banner = document.head.querySelector('meta[name="banner-app"]');
const pathBanner = banner ? banner?.content : "/";
globalThis.$pathBanner = pathBanner;


// icon app
const icon = document.head.querySelector('meta[name="icon-app"]');
const pathIcon = icon ? icon?.content : "/";
globalThis.$pathIcon = pathIcon;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        const pinia = createPinia();
        pinia.use(piniaPluginPersistedstate);
        const VueApp = createApp({ render: () => h(app, props) });

        // use
        VueApp.use(plugin)
            .use(VueSweetalert2)
            .use(PrimeVue)
            .use(pinia)
            .use(Datepicker)
            .use(ZiggyVue, Ziggy);

        // mount app
        VueApp.mount(el);

        return { VueApp };
    },
});

InertiaProgress.init({ color: "#4B5563" });
