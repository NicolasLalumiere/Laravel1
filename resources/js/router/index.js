import Vue from "vue";
import Router from "vue-router";

import Home from "../pages/Home";
import Dashboard from "../pages/Dashboard";
import Login from "../pages/Login";
import Voyages from "../components/Voyages";

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
        name: "login",
        path: "/login",
        component: Login,
    },
];

const router = new Router({
    mode: "history", // Utilise le mode historique
    routes,
});

export default router;
