import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoggedIn: false, // État de la connexion
        errorMessage: "", // État pour stocker le message d'erreur
    },
    mutations: {
        setLoggedIn(state, status) {
            state.isLoggedIn = status;
        },
        setErrorMessage(state, message) {
            state.errorMessage = message;
        },
    },
    actions: {
        checkLoginStatus({ commit }) {
            if (localStorage.getItem("token")) {
                commit("setLoggedIn", true);
            } else {
                commit("setLoggedIn", false);
            }
        },
        logout({ commit }) {
            commit("setLoggedIn", false);
            localStorage.removeItem("token"); // Supprimer le token
        },
        async registerUser({ commit }, formData) {
            commit("setErrorMessage", ""); // Réinitialiser l'erreur
            try {
                const response = await axios.post("/api/register", formData);
                alert("Inscription réussie ! Veuillez vous connecter.");
                return response;
            } catch (error) {
                if (error.response) {
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        commit(
                            "setErrorMessage",
                            errors.name?.[0] ||
                                errors.email?.[0] ||
                                errors.password?.[0] ||
                                "Une erreur s'est produite. Veuillez réessayer."
                        );
                    } else {
                        commit(
                            "setErrorMessage",
                            error.response.data.message || "Erreur inconnue."
                        );
                    }
                } else if (error.request) {
                    commit(
                        "setErrorMessage",
                        "Impossible de se connecter au serveur."
                    );
                } else {
                    commit(
                        "setErrorMessage",
                        "Une erreur interne s'est produite."
                    );
                }
                throw error; // Rejeter l'erreur pour la gérer dans le composant
            }
        },
        async loginUser({ commit }, credentials) {
            commit("setErrorMessage", ""); // Réinitialiser l'erreur
            try {
                const response = await axios.post("/api/login", credentials);

                // Stocker le token dans le localStorage
                const token = response.data[0].token;
                localStorage.setItem("token", token);

                // Modifier l'état de connexion
                commit("setLoggedIn", true);
            } catch (error) {
                if (error.response) {
                    commit(
                        "setErrorMessage",
                        "Identifiants incorrects. Veuillez réessayer."
                    );
                } else if (error.request) {
                    commit(
                        "setErrorMessage",
                        "Impossible de se connecter au serveur."
                    );
                } else {
                    commit(
                        "setErrorMessage",
                        "Une erreur interne s'est produite."
                    );
                }
                throw error; // Rejeter l'erreur pour la gérer dans le composant
            }
        },
    },
});
