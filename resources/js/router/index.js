import Vue from "vue";
import Router from "vue-router";

import Home from "../pages/Home";
import Dashboard from "../pages/Dashboard";
import Login from "../pages/Login";
import Register from "../pages/Register";
import Voyages from "../components/Voyages";
import AjoutVoyage from "../components/AjoutVoyage.vue";
import ModifierVoyage from "../components/ModifierVoyage.vue";
import APropos from "../pages/APropos.vue";

// Inscrire Vue Router
Vue.use(Router);

export const routes = [
    {
        name: "home",
        path: "/",
        component: Home,
    },
    {
        name: "dashboard",
        path: "/dashboard",
        component: Dashboard,
    },
    {
        name: "voyages",
        path: "/voyages",
        component: Voyages,
    },
    {
        name: "ajoutVoyages",
        path: "/voyages/ajout",
        component: AjoutVoyage,
    },
    {
        name: "modifierVoyage",
        path: "/voyages/modifier",
        component: ModifierVoyage,
    },
    {
        name: "aPropos",
        path: "/apropos",
        component: APropos,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
    {
        name: "register",
        path: "/register",
        component: Register,
    },
];

const router = new Router({
    mode: "history",
    routes,
});

export default router;
