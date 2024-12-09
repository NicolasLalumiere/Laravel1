<template>
    <div>
        <h4 class="text-center">Tous les voyages</h4>
        <br />

        <!-- Barre de recherche avec suggestions -->
        <div v-if="!isAuthenticated" class="mb-3">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Rechercher par pays..."
                class="form-control"
                @input="updateSuggestions"
            />
            <ul v-if="suggestions.length > 0" class="dropdown-menu show">
                <li
                    v-for="(suggestion, index) in suggestions"
                    :key="index"
                    @click="selectSuggestion(suggestion)"
                >
                    {{ suggestion }}
                </li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Pays</th>
                    <th>Jours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="filteredVoyages.length === 0">
                    <td colspan="4" class="text-center">
                        Aucun voyage disponible
                    </td>
                </tr>
                <tr v-for="voyage in filteredVoyages" :key="voyage.id">
                    <td>
                        <img
                            :src="`/images/upload/` + voyage.photo"
                            alt="Photo de voyage"
                            width="100"
                        />
                    </td>
                    <!-- Les champs Pays et Jours, avec gestion de la visibilité -->
                    <td v-if="visibleVoyages.includes(voyage.id)">{{ voyage.pays }}</td>
                    <td v-else></td>

                    <td v-if="visibleVoyages.includes(voyage.id)">{{ voyage.jours }}</td>
                    <td v-else></td>

                    <!-- Boutons d'actions -->
                    <td>
                        <div class="btn-group" role="group">
                            
                            <router-link
                                :to="{
                                    name: 'modifierVoyage',
                                    params: { id: voyage.id },
                                }"
                                class="btn btn-primary"
                                v-if="isAuthenticated"
                            >
                                Modifier
                            </router-link>
                            <button
                                v-if="isAuthenticated"
                                class="btn btn-danger"
                                @click="deleteVoyage(voyage.id)"
                            >
                                Supprimer
                            </button>
                            <button
                                class="btn btn-secondary"
                                @click="toggleVisibility(voyage.id)"
                            >
                                Afficher
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <button
            v-if="isAuthenticated"
            type="button"
            class="btn btn-info"
            @click="$router.push('/voyages/ajout')"
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
            voyages: [],
            searchQuery: '',
            suggestions: [],
            visibleVoyages: [], // Liste des IDs des voyages avec champs visibles
        };
    },
    computed: {
        ...mapState(["isLoggedIn", "user"]),
        isAuthenticated() {
            return this.isLoggedIn;
        },
        filteredVoyages() {
            if (this.searchQuery.trim() === '') {
                return this.voyages;
            }
            return this.voyages.filter((voyage) =>
                voyage.pays.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
    },
    async created() {
        try {
            const response = await this.$axios.get("/api/voyages");
            this.voyages = response.data;
        } catch (error) {
            console.error("Erreur lors de la récupération des voyages:", error);
        }
    },
    methods: {
        async deleteVoyage(id) {
            try {
                await this.$axios.get("/sanctum/csrf-cookie");
                await this.$axios.delete(`/api/destroy/${id}`);
                this.voyages = this.voyages.filter((voyage) => voyage.id !== id);
                this.visibleVoyages = this.visibleVoyages.filter((vid) => vid !== id);
            } catch (error) {
                console.error("Erreur lors de la suppression du voyage:", error);
            }
        },
        updateSuggestions() {
            if (this.searchQuery.trim() === '') {
                this.suggestions = [];
                return;
            }
            this.suggestions = this.voyages
                .map((voyage) => voyage.pays)
                .filter(
                    (pays, index, self) =>
                        self.indexOf(pays) === index &&
                        pays.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
                .slice(0, 5);
        },
        selectSuggestion(suggestion) {
            this.searchQuery = suggestion;
            this.suggestions = [];
        },
        toggleVisibility(id) {
            if (this.visibleVoyages.includes(id)) {
                this.visibleVoyages = this.visibleVoyages.filter((vid) => vid !== id);
            } else {
                this.visibleVoyages.push(id);
            }
        },
    },
};
</script>
