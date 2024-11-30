<template>
    <div class="container">
        <div
            class="text-center"
            style="
                margin: 20px 0px 20px 0px;
                background-color: #2769b0;
                color: #ffff;
            "
        >
            <h2>Site monopage Laravel-Vue avec authentification</h2>
        </div>
        <nav
            class="navbar navbar-expand-lg navbar-light bg-light"
            style="background-color: #3485dc; color: #ffff"
        >
            <div
                class="collapse navbar-collapse"
                style="background-color: #3485dc; color: #ffff"
            >
                <!-- for logged-in user -->
                <div v-if="isLoggedIn" class="navbar-nav">
                    <router-link to="/dashboard" class="nav-item nav-link"
                        >Dashboard</router-link
                    >
                    <router-link to="/voyages" class="nav-item nav-link"
                        >Voyages</router-link
                    >
                    <a
                        class="nav-item nav-link"
                        style="cursor: pointer"
                        @click="logout"
                        >Déconnexion</a
                    >
                </div>
                <!-- for non-logged user -->
                <div v-else class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link"
                        >Accueil</router-link
                    >
                    <router-link to="/voyages" class="nav-item nav-link"
                        >Voyages</router-link
                    >
                    <router-link to="/login" class="nav-item nav-link"
                        >Connexion</router-link
                    >
                    <router-link to="/register" class="nav-item nav-link"
                        >Inscription</router-link
                    >
                    <router-link to="/about" class="nav-item nav-link"
                        >A propos</router-link
                    >
                </div>
            </div>
        </nav>
        <br />
        <router-view />
    </div>
</template>

<script>
export default {
    name: "App",
    computed: {
        // Accéder à l'état de la connexion depuis le store
        isLoggedIn() {
            return this.$store.state.isLoggedIn;
        },
    },
    created() {
        // Vérifier l'état de la session lors de la création du composant
        this.$store.dispatch("checkLoginStatus");
    },
    methods: {
        logout(e) {
            e.preventDefault();
            this.$axios.get("/sanctum/csrf-cookie").then(() => {
                this.$axios
                    .post("/api/logout")
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.dispatch("logout"); // Appeler l'action de déconnexion
                            this.$router.push("/"); // Rediriger vers la page d'accueil
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
