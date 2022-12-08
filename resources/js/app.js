import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";


// sweetalert2
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

//primeVue
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css'

// app name
const searchTag = globalThis.document.getElementsByTagName("title");
const appName = searchTag[0]?.innerText || "App vehículos";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        const VueApp = createApp({ render: () => h(app, props) });

        // use
        VueApp.use(plugin).use(VueSweetalert2).use(PrimeVue).use(ZiggyVue, Ziggy);

        // mount app
        VueApp.mount(el);

        return { VueApp };
    },
});

InertiaProgress.init({ color: "#4B5563" });
