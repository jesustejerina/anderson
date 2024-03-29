import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import { SnackbarService, Vue3Snackbar } from "vue3-snackbar";
import "vue3-snackbar/styles";
import "./main.css";
const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(router);
app.use(SnackbarService);
app.component("vue3-snackbar", Vue3Snackbar);
app.mount("#app");
