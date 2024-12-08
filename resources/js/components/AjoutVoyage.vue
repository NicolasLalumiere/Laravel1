<template>
    <div class="ajout-voyage">
      <h1>Ajouter un Voyage</h1>
      <form @submit.prevent="ajouterVoyage">
  
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
  
        <button type="submit">Ajouter le Voyage</button>
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
      async ajouterVoyage() {
        const formData = new FormData();
        const userId = this.$store.state.user.id; // Exemple pour stocker l'ID utilisateur localement
        formData.append("user_id", userId);
        formData.append("pays", this.voyage.pays);
        formData.append("jours", this.voyage.jours);
        if (this.voyage.photo) {
          formData.append("photo", this.voyage.photo);
        }
  
        try {
        const response = await this.$axios.post("/api/store", formData, {
            headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
        });

        if (response.status === 201) {
            alert("Voyage ajouté avec succès !");
            this.$router.push({ name: "voyages" });
        } else {
            alert("Erreur : " + response.data.message);
        }
        } catch (error) {
        alert("Une erreur s'est produite : " + (error.response?.data.message || error.message));
        }

      },
    },
  };
  </script>
  
  <style scoped>
  .ajout-voyage {
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
  