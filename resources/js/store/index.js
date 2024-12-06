import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isLoggedIn: false, // État de la connexion
        user: null, // État pour stocker les informations de l'utilisateur
        errorMessage: "", // État pour stocker le message d'erreur
        userVoyages: [], // État pour stocker les voyages de l'utilisateur connecté
    },
    mutations: {
        setLoggedIn(state, status) {
            state.isLoggedIn = status;
        },
        setUser(state, user) {
            state.user = user;
        },
        setErrorMessage(state, message) {
            state.errorMessage = message;
        },
        setUserVoyages(state, voyages) {
            state.userVoyages = voyages;
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
            commit("setUserVoyages", []); // Réinitialiser les voyages lors de la déconnexion
            localStorage.removeItem("token"); // Supprimer le token
        },
        async loginUser({ commit }, credentials) {
            commit("setErrorMessage", ""); // Réinitialiser l'erreur
            try {
                const response = await axios.post("/api/login", credentials);

                // Stocker le token dans le localStorage
                const token = response.data[0].token;
                localStorage.setItem("token", token);

                // Récupérer les détails de l'utilisateur
                const userResponse = await axios.get("/api/user"); // Assurez-vous que cette route renvoie les détails de l'utilisateur connecté
                commit("setUser", userResponse.data);

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

        async fetchUserVoyages({ commit, state }) {
            if (state.isLoggedIn && state.user) {
                try {
                    const response = await axios.get("/api/voyages/user");
                    commit("setUserVoyages", response.data);
                } catch (error) {
                    console.error(
                        "Erreur lors de la récupération des voyages :",
                        error
                    );
                }
            }
        },
    },
});
