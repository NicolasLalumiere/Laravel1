<template>
    <div class="login-container">
        <h2>Connexion</h2>
        <form @submit.prevent="loginUser">
            <div class="form-group">
                <label for="email">Email:</label>
                <input
                    type="email"
                    id="email"
                    v-model="email"
                    class="form-control"
                    required
                />
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input
                    type="password"
                    id="password"
                    v-model="password"
                    class="form-control"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    computed: {
        // Accéder au message d'erreur depuis le store
        errorMessage() {
            return this.$store.state.errorMessage;
        },
    },
    methods: {
        async loginUser() {
            try {
                // Appeler l'action Vuex pour gérer la connexion
                await this.$store.dispatch("loginUser", {
                    email: this.email,
                    password: this.password,
                });

                // Si la connexion réussit, rediriger vers la page des voyages
                this.$router.push("/voyages");
            } catch (error) {
                console.error("Erreur lors de la connexion :", error);
            }
        },
    },
};
</script>

<style scoped>
.login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}
</style>
