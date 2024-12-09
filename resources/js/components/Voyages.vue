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
                <li v-for="(suggestion, index) in suggestions" :key="index" @click="selectSuggestion(suggestion)">
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
                    <th v-if="isAuthenticated">Actions</th>
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
                    <td>{{ voyage.pays }}</td>
                    <td>{{ voyage.jours }}</td>
                    <td v-if="isAuthenticated">
                        <div class="btn-group" role="group">
                            <router-link
                                :to="{
                                    name: 'modifierVoyage',
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
            suggestions: [], // Liste des suggestions pour l'autocomplétion
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
            if (this.isAuthenticated) {
                const response = await this.$axios.get("/api/voyages");
                this.voyages = response.data;
            } else {
                const response = await this.$axios.get("/api/voyages");
                this.voyages = response.data;
            }
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
                .map(voyage => voyage.pays)
                .filter((pays, index, self) =>
                    self.indexOf(pays) === index && pays.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
                .slice(0, 5); // Limiter à 5 suggestions
        },
        selectSuggestion(suggestion) {
            this.searchQuery = suggestion;
            this.suggestions = []; // Cacher la liste après la sélection
        }
    },
};
</script>

<style scoped>
.dropdown-menu {
    position: absolute;
    width: 100%;
    background-color: white;
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;
}
.dropdown-menu li {
    padding: 8px;
    cursor: pointer;
}
.dropdown-menu li:hover {
    background-color: #f1f1f1;
}
</style>
