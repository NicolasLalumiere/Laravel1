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
          <label>Photo :</label>
          <div 
            class="drag-drop-zone" 
            @dragover.prevent="handleDragOver" 
            @dragleave="handleDragLeave" 
            @drop.prevent="handleDrop"
            :class="{ 'drag-over': isDragging }"
          >
            <p v-if="!voyage.photo">Déposez votre image ici ou cliquez pour sélectionner</p>
            <p v-else>{{ voyage.photo.name }}</p>
            <input type="file" id="photo" @change="handleFileUpload" hidden ref="fileInput" />
          </div>
          <button type="button" @click="triggerFileInput">Sélectionner une image</button>
        </div>
  
        <button type="submit">Modifier le Voyage</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isDragging: false,
        voyage: {
          pays: "",
          jours: 1,
          photo: null,
        },
      };
    },
    methods: {
      triggerFileInput() {
        this.$refs.fileInput.click();
      },
      handleFileUpload(event) {
        const file = event.target.files[0];
        this.voyage.photo = file;
      },
      handleDragOver() {
        this.isDragging = true;
      },
      handleDragLeave() {
        this.isDragging = false;
      },
      handleDrop(event) {
        const file = event.dataTransfer.files[0];
        this.voyage.photo = file;
        this.isDragging = false;
      },
      async modifierVoyage() {
        try {
          await this.$axios.get("/sanctum/csrf-cookie");
  
          const userId = this.$store.state.user.id;
          const formData = new FormData();
          formData.append("_method", "PUT");
          formData.append("user_id", userId);
          formData.append("pays", this.voyage.pays);
          formData.append("jours", String(this.voyage.jours));
          if (this.voyage.photo) {
            formData.append("photo", this.voyage.photo);
          }
  
          const voyageId = this.$route.params.id;
          const response = await this.$axios.put(`/api/update/${voyageId}`, formData, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "multipart/form-data",
              Accept: "application/json",
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
  
  .drag-drop-zone {
    width: 100%;
    padding: 20px;
    border: 2px dashed #ccc;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 10px;
    background-color: #f9f9f9;
    cursor: pointer;
  }
  
  .drag-drop-zone.drag-over {
    background-color: #e0f7fa;
    border-color: #00796b;
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
  