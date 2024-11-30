<template>
    <div class="auth-container">
        <h2>Créer un compte</h2>
        <form @submit.prevent="registerUser">
            <!-- Champs du formulaire -->
            <div class="form-group">
                <label for="name">Nom</label>
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-control"
                    placeholder="Votre nom"
                    required
                />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="form-control"
                    placeholder="Votre adresse email"
                    required
                />
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    v-model="form.password"
                    class="form-control"
                    placeholder="Votre mot de passe"
                    required
                />
            </div>

            <div class="form-group">
                <label for="password_confirmation"
                    >Confirmer le mot de passe</label
                >
                <input
                    type="password"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="form-control"
                    placeholder="Confirmez votre mot de passe"
                    required
                />
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>

        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

        <p class="auth-switch">
            Déjà inscrit ?
            <router-link to="/login">Connectez-vous ici</router-link>.
        </p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
        };
    },
    computed: {
        // Accéder au message d'erreur depuis le store
        errorMessage() {
            return this.$store.state.errorMessage;
        },
    },
    methods: {
        async registerUser() {
            try {
                // Appeler l'action Vuex pour enregistrer l'utilisateur
                await this.$store.dispatch("registerUser", this.form);

                // Redirection vers la page de connexion après l'inscription réussie
                this.$router.push("/login");
            } catch (error) {
                console.error("Erreur lors de l'inscription :", error);
            }
        },
    },
};
</script>

<style scoped>
.auth-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

.auth-container h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

.auth-switch {
    margin-top: 15px;
    font-size: 14px;
}
</style>
