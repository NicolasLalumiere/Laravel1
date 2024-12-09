<template>
    <div class="modifier-voyage">
      <h1>Modifier un Voyage</h1>
      <form @submit.prevent="modifierVoyage">
  
        <div class="form-group">
          <label for="pays">Pays :</label>
          <input type="text" id="pays" v-model="voyage.pays" required />
        </div>
  
        <div class="form-group">
          <label for="jours">Durée (en jours) :</label>
          <input type="number" id="jours" v-model="voyage.jours" required min="1" />
        </div>
  
        <div class="form-group">
          <label for="photo">Photo :</label>
          <input type="file" id="photo" @change="handleFileUpload" />
        </div>
  
        <button type="submit">Modifier le Voyage</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        voyage: {
          pays: "",
          jours: 1,
          photo: null,
        },
      };
    },
    methods: {
      handleFileUpload(event) {
        const file = event.target.files[0];
        this.voyage.photo = file;
      },
      async modifierVoyage() {
    try {
        await this.$axios.get("/sanctum/csrf-cookie");

        const formData = new FormData();
        const userId = this.$store.state.user.id;
        formData.append("user_id", userId);
        formData.append("pays", this.voyage.pays);
        formData.append("jours", parseInt(this.voyage.jours, 10));
        if (this.voyage.photo) {
            formData.append("photo", this.voyage.photo);
        }

        // Afficher les données de FormData dans la console pour déboguer
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        const voyageId = this.$route.params.id;
        const response = await this.$axios.put(`/api/update/${voyageId}`, formData, {
            headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            'Content-Type': 'multipart/form-data'
            },
        });

        console.log("Voyage mis à jour :", response.data);
        this.$router.push("/voyages");
    } catch (error) {
        console.error("Erreur lors de la modification du voyage :", error);
    }
},
  },
  async created() {
    // Vous devez charger les détails du voyage existant pour l'afficher dans le formulaire
    const voyageId = this.$route.params.id;
    try {
      const response = await this.$axios.get(`/api/voyages/${voyageId}`);
      this.voyage = response.data;
    } catch (error) {
      console.error("Erreur lors du chargement des détails du voyage :", error);
    }
  },
};
  </script>
  
  <style scoped>
  .modifier-voyage {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  input,
  textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #218838;
  }
  </style>