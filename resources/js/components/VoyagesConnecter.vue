<template>
    <div>
        <h4 class="text-center">Tous les voyages</h4>
        <br />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Pays</th>
                    <th>Jours</th>
                    <th v-if="isAuthenticated">Actions</th>
                    <!-- Afficher uniquement si connecté -->
                </tr>
            </thead>
            <tbody>
                <tr v-if="voyages.length === 0">
                    <td colspan="4" class="text-center">
                        Aucun voyage disponible
                    </td>
                </tr>
                <tr v-for="voyage in voyages" :key="voyage.id">
                    <td>
                        <img
                            :src="'/storage/' + voyage.photo"
                            alt="Photo de voyage"
                            width="100"
                        />
                    </td>
                    <td>{{ voyage.pays }}</td>
                    <td>{{ voyage.jours }}</td>
                    <td v-if="isAuthenticated">
                        <div class="btn-group" role="group">
                            <router-link
                                :to="{
                                    name: 'editvoyage',
                                    params: { id: voyage.id },
                                }"
                                class="btn btn-primary"
                            >
                                Modifier
                            </router-link>
                            <button
                                class="btn btn-danger"
                                @click="deleteVoyage(voyage.id)"
                            >
                                Supprimer
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Afficher le bouton "Ajouter Voyage" seulement si l'utilisateur est connecté -->
        <button
            v-if="isAuthenticated"
            type="button"
            class="btn btn-info"
            @click="this.$router.push('/store')"
        >
            Ajouter Voyage
        </button>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    data() {
        return {
            voyages: [], // Initialisation de la liste des voyages
        };
    },
    computed: {
        ...mapState(["isLoggedIn", "user"]), // Accéder à l'état du store
        isAuthenticated() {
            return this.isLoggedIn; // Utiliser la valeur de isLoggedIn du store
        },
    },
    async created() {
        await this.$store.dispatch("checkLoginStatus");
        if (this.isAuthenticated) {
            try {
                const response = await this.$axios.get("/api/voyages/user");
                this.voyages = response.data;
            } catch (error) {
                console.error(
                    "Erreur lors de la récupération des voyages (utilisateur connecté):",
                    error
                );
            }
        } else {
            try {
                const response = await this.$axios.get("/api/voyages");
                this.voyages = response.data;
            } catch (error) {
                console.error(
                    "Erreur lors de la récupération des voyages (utilisateur non connecté):",
                    error
                );
            }
        }
    },
    methods: {
        async deleteVoyage(id) {
            try {
                await this.$axios.get("/sanctum/csrf-cookie");
                await this.$axios.delete(`/api/voyages/destroy/${id}`);
                // Enlever le voyage supprimé de la liste
                this.voyages = this.voyages.filter(
                    (voyage) => voyage.id !== id
                );
            } catch (error) {
                console.error(
                    "Erreur lors de la suppression du voyage:",
                    error
                );
            }
        },
    },
};
</script>
