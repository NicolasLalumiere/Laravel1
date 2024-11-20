import { createApp } from "vue"; // Assurez-vous d'utiliser Vue 3.
import router from "./router/index"; // Importez votre fichier de routes.
import axios from "axios";
import VueAxios from "vue-axios";
import App from "./App.vue"; // Importez le composant principal App.vue.

// Configure Axios avec le jeton CSRF et l'URL de base.
axios.defaults.headers.common["X-CSRF-TOKEN"] = document.querySelector(
    'meta[name="csrf-token"]'
).content;
axios.defaults.baseURL = "/";

// Créez l'application Vue.
const app = createApp(App);

// Utilisez Vue Router et Axios.
app.use(router);
app.use(VueAxios, axios);

// Montez l'application sur le div #app.
app.mount("#app");
