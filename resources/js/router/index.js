import { createWebHistory, createRouter } from "vue-router";

//import Home from "../pages/Home";
//import About from "../pages/About";
//import Register from "../pages/Register";
//import Login from "../pages/Login";
//import Dashboard from "../pages/Dashboard";

import Voyages from "../components/Voyages";
//import AddArticle from "../components/AddArticle";
//import EditArticle from "../components/EditArticle";

export const routes = [
    {
        name: "home",
        path: "/",
        component: Home,
    },
    {
        name: "about",
        path: "/about",
        component: About,
    },
    {
        name: "register",
        path: "/register",
        component: Register,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
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
        name: "addvoyage",
        path: "/voyages/add",
        component: AddVoyage,
    },
    {
        name: "editvoyage",
        path: "/voyages/edit/:id",
        component: EditVoyage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
