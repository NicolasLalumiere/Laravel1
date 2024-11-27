import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";

// Ajouter Axios en tant que prototype global
Vue.prototype.$axios = axios;

// Créer une instance Vue
new Vue({
    render: (h) => h(App),
    router,
}).$mount("#app");
