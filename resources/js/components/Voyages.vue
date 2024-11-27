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
                                >Modifier</router-link
                            >
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
export default {
    data() {
        return {
            voyages: [], // Initialisation de la liste des voyages
            isAuthenticated: false, // Initialisation de l'état d'authentification
        };
    },
    created() {
        // Vérifier si l'utilisateur est authentifié
        this.checkAuthentication();

        // Faire une requête pour récupérer tous les voyages (publique)
        this.$axios.get("/sanctum/csrf-cookie").then(() => {
            this.$axios
                .get("api/voyages") // Accès à la route API pour récupérer les voyages
                .then((response) => {
                    this.voyages = response.data; // Stocker les voyages dans le tableau
                })
                .catch((error) => {
                    console.error(
                        "Erreur lors de la récupération des voyages:",
                        error
                    );
                });
        });
    },
    methods: {
        // Vérifier si l'utilisateur est connecté
        checkAuthentication() {
            this.$axios
                .get("/api/user")
                .then((response) => {
                    // Si l'utilisateur est connecté, on le considère authentifié
                    this.isAuthenticated = true;
                })
                .catch(() => {
                    // Si l'utilisateur n'est pas connecté, on le considère non authentifié
                    this.isAuthenticated = false;
                });
        },
        // Méthode pour supprimer un voyage
        deleteVoyage(id) {
            this.$axios.get("/sanctum/csrf-cookie").then(() => {
                this.$axios
                    .delete(`/api/voyages/destroy/${id}`) // Route API pour supprimer un voyage
                    .then(() => {
                        // Enlever le voyage supprimé de la liste
                        this.voyages = this.voyages.filter(
                            (voyage) => voyage.id !== id
                        );
                    })
                    .catch((error) => {
                        console.error(
                            "Erreur lors de la suppression du voyage:",
                            error
                        );
                    });
            });
        },
    },
};
</script>
