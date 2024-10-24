@php $locale = session()->get('locale'); @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Carnet de voyages</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #ebe9e9;
}

/* Header */
header {
    color: rgb(3, 0, 0);
    text-align: center;
    padding: 80px 0;
}

header h1 {
    font-size: 3em;
    margin: 0;
    color: black;
}

/* Navigation */
nav {
    display: flex;
    justify-content: space-around;
    background-color: #333;
    padding: 10px;
}

nav a {
    color: white;
    text-decoration: none;
    font-size: 18px;
}

nav a:hover {
    text-decoration: underline;
}

/* Conteneur principal */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

/* Articles */
.articles {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.article {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: calc(33.333% - 20px);
}

.article img {
    width: 100%;
    border-radius: 8px 8px 0 0;
}

.article h2 {
    font-size: 1.5em;
    margin: 15px 0;
}

.article p {
    font-size: 1em;
    color: #555;
}

/* Styles pour les voyages récupérés via PHP */
.voyage {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.voyage p {
    font-size: 1em;
    color: #333;
}

.voyage strong {
    font-weight: bold;
    color: #333;
}

.voyage em {
    color: #777;
}

/* Boutons modifier et supprimer */
.voyage a {
    text-decoration: none;
    padding: 5px 10px;
    margin-right: 10px;
    font-size: 0.9em;
    border-radius: 5px;
    color: white;
    background-color: #5fa8d3;
    transition: background-color 0.3s ease;
}

.modifier {
    background-color: #5fa8d3; /* Couleur de fond pour le bouton Modifier */
    color: white; /* Couleur du texte */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    padding: 10px 15px; /* Espacement intérieur */
    cursor: pointer; /* Curseur pointer */
    transition: background-color 0.3s ease; /* Effet de transition */
}

.modifier:hover {
    background-color: #4a91b3; /* Couleur de fond au survol */
}

.supprimer {
    background-color: #d35f5f; /* Couleur de fond pour le bouton Supprimer */
    color: white; /* Couleur du texte */
    border: none; /* Pas de bordure */
    border-radius: 5px; /* Coins arrondis */
    padding: 10px 15px; /* Espacement intérieur */
    cursor: pointer; /* Curseur pointer */
    transition: background-color 0.3s ease; /* Effet de transition */
}

.supprimer:hover {
    background-color: #b34a4a; /* Couleur de fond au survol */
}
/* Footer */
footer {
    text-align: center;
    padding: 20px;
    background-color: #333;
    color: white;
    margin-top: 50px;
}

/* Responsiveness */
@media (max-width: 768px) {
    .articles {
        flex-direction: column;
        gap: 10px;
    }

    .article,
    .voyage {
        width: 100%;
    }
}
</style>
</head>
<body>

<header> 
    <a href="tests.php">
        <h3>TESTS</h3>
    </a>

<?php if (isset($utilisateur)) : ?>
                        <h3>Bonjour <?= $utilisateur['prenom'] ?>,
                            <a href="index.php?controleur=utilisateurs&action=deconnecter"><small>[Se déconnecter]</small></a>
                        </h3>
                    <?php else : ?>
                        <h3>[<a href="{{ route('login') }}">Se connecter</a>]</h3>
                        <h3>[<a href="{{ route('register') }}">S'enregistrer</a>]</h3>
                    <?php endif; ?>

    <h1>Bienvenue sur les carnets de voyages en ligne</h1>
    <p style="color: black;">Faites découvrir vos aventures autour du monde!</p>
   
</header>

<nav>
    <a href="{{url('/')}}">Accueil</a> 
    <a href="{{url('/voyages/ajouter')}}">Ajouter des infos</a>
    <a href="{{url('/apropos')}}">À propos</a>
</nav>

<main class="py-4">
            @yield('content')
</main>

<footer>
    <p>&copy; 2024 Mon Carnet de Voyage - Fait avec HTML5, CSS et PHP</p>
</footer>

</body>

</html>