import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import piniaPluginPersistedState from "pinia-plugin-persistedstate";
import Vue3Toasity, { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Spinner from "./components/Spinner.vue";
import "@vueform/multiselect/themes/default.css";
// import VueApexCharts from "vue3-apexcharts";
import CanvasJSChart from '@canvasjs/vue-charts';
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

import App from "./App.vue";
import router from "./router";

const app = createApp(App);
const pinia = createPinia();
pinia.use(piniaPluginPersistedState);

app.component("Spinner", Spinner);

app.use(router);
app.use(pinia);
app.use(CanvasJSChart);
app.use(ElementPlus);
app.use(Vue3Toasity, {
    autoClose: 3000,
});

app.mount("#app");
