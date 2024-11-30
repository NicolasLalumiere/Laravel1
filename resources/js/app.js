import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";
import store from "./store"; // Importer le store

// Ajouter Axios en tant que prototype global
Vue.prototype.$axios = axios;

// Créer une instance Vue en ajoutant le store
new Vue({
    render: (h) => h(App),
    router,
    store, // Ajouter le store ici
}).$mount("#app");
