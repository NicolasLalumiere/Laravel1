<template>
    <div>
      <h1>A propos</h1>
      <p>Voici mon Carnet de voyage version monopage!</p>
  
      <p>
        Dans cette version du site, tous les voyages de tous les utilisateurs sont encore visibles lorsque nous cliquons sur l’onglet voyage. Cependant, les champs ne sont pas visibles automatiquement, il faut appuyer sur le bouton afficher pour que ces champs affichent leur information correspondante pour le voyage sélectionné.
      </p>
  
      <p>
        Cette version du site possède également une barre de recherche qui filtre les voyages affichés en fonction de si les lettres entrées dans la barre de recherche correspondent à des lettres présentes dans le champ pays du voyage. Lorsque nous entrons des lettres dans la barre de recherche, celle-ci va créer une liste déroulante nous montrant tous les pays pouvant correspondre à ces lettres. Si nous appuyons sur une de ces options, cela va entrer le pays au complet dans la barre de recherche et ainsi compléter le filtre.
      </p>
  
      <p>
        Nous avons des onglets Connexion et Inscription quand nous ne sommes pas connectés au site. L’onglet inscription nous redirige vers un formulaire qui va permettre de créer un utilisateur dans la base de données. S’inscrire n’ouvre pas notre session, il faut par la suite aller dans l’onglet Connexion pour se connecter à notre session. Une fois connecté, nous ne voyons plus les onglets de connexion et d’inscription, nous voyons maintenant un onglet de Déconnexion que si nous appuyons dessus, va mettre fin à notre session.
      </p>
  
      <p>Voici un utilisateur que vous pouvez utiliser pour ouvrir une session :</p>
      <ul>
        <li>Courriel : max@test.com</li>
        <li>Mot de passe : Max12345!</li>
      </ul>
  
      <p>
        Quand nous sommes connectés, nous pouvons voir que dans l’onglet de voyages, nous voyons uniquement nos voyages et pas ceux des autres utilisateurs. De plus, nous avons maintenant accès aux boutons ajouter, supprimer et modifier. Ajouter et modifier nous amènent respectivement à des formulaires nous permettant d’ajouter un nouveau voyage ou modifier un voyage existant. Le bouton supprimer va tout simplement supprimer le voyage correspondant.
      </p>
    </div>
  </template>
  
  <script>
  export default {
    name: "APropos",
  };
  </script>
  
  <style scoped>
  /* Ajoutez des styles personnalisés ici si nécessaire */
  </style>
  