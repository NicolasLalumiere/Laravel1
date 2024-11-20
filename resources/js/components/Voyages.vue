<template>
    <div>
        <h4 class="text-center">All articles</h4>
        <br />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="voyage in voyages" :key="voyage.id">
                    <td>{{ voyage.photo }}</td>
                    <td>{{ voyage.pays }}</td>
                    <td>{{ voyage.jours }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link
                                :to="{
                                    name: 'editvoyage',
                                    params: { id: voyage.id },
                                }"
                                class="btn btn-primary"
                                >Modifier
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
            articles: [],
        };
    },
    created() {
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            this.$axios
                .get("api/voyages")
                .then((response) => {
                    this.voyages = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
    methods: {
        deleteVoyage(id) {
            this.$axios.get("/sanctum/csrf-cookie").then((response) => {
                this.$axios
                    .delete(`/api/voyages/delete/${id}`) // possiblement api/delete/... en fonction de la route que je viens de donner pas certain
                    .then((response) => {
                        let i = this.voyages.map((item) => item.id).indexOf(id); // find index of your object
                        this.voyages.splice(i, 1);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        },
    },
};
</script>
