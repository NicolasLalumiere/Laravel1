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
        <p v-if="error" class="error-message">{{ error }}</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            email: "",
            password: "",
            error: "",
        };
    },
    methods: {
        async loginUser() {
            this.error = ""; // Réinitialiser l'erreur à chaque tentative de connexion

            try {
                const response = await axios.post("api/login", {
                    email: this.email,
                    password: this.password,
                });

                // Si la connexion est réussie
                const token = response.data[0].token;
                localStorage.setItem("token", token); // Stocker le token localement

                // Rediriger vers la page des voyages
                this.$router.push("/voyages");
            } catch (error) {
                this.error = "Identifiants incorrects. Veuillez réessayer."; // Gérer l'erreur
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
