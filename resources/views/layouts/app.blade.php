@php $locale = session()->get('locale'); @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Carnet de voyages</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- JQuery -->
     {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style>
            body {
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


<nav>
    <div class="car-body">
    @guest
                    <form>
                        @csrf
                        <div class="form-group">
                            <input type="text" class="typeahead form-control" id = "voyage_search"
                                placeholder = @lang('general.Recherche')>
                        </div>
                    </form>
                    <script type="text/javascript">
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $(document).ready(function() {
                            $('#voyage_search').autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: "{{ route('autocomplete') }}",
                                        type: 'POST',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            search: request.term
                                        },
                                        success: function(data) {
                                            response(data);
                                        }
                                    });
                                },
                                select: function(event, ui) {
                                    $('#voyage_search').val(ui.item.label);

                                    return false;
                                }
                            });
                        });
                    </script>
                     @endguest
                </div>
    <a href="{{ url('lang/fr') }}">Français</a>
    <a href="{{ url('lang/en') }}">English</a>
    <a href="{{ url('lang/es') }}">Español</a>
</nav>

    <a href="tests.php">
        <h3>@lang('general.tests')</h3>
    </a>

    @if (Auth::user()) {{-- accées au boutons d"enregistrement de connéexion et de déconnexion peu importe le rôle de l'utilisateur authentifié --}}
                       
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @lang('general.deconnexion')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <h2>
                            @lang('general.Bonjour') {{ Auth::user()->name }}
                            </h2>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                            
                            </div>
            
                    @else
                        <a class="nav-link" href="{{ route('login') }}">@lang('general.connexion')</a>
                        <a class="nav-link" href="{{ route('register') }}">@lang('general.inscription')</a>

            @endif

    <h1>@lang('general.Bienvenue')</h1>
    <p style="color: black;">@lang('general.Decouvrir')</p>
   
</header>

<nav>
    <a href="{{url('/')}}">@lang('general.Accueil')</a> 
    @if (Auth::user())
    <a href="{{ route('ajouter') }}">@lang('general.Ajouter des infos')</a>
    @endif
    <a href="{{url('/apropos')}}">@lang('general.A propos')</a>
    @if (Auth::user() && Auth::user()->role === 'ADMIN' && !Request::is('admin'))
            <a href="{{ url('/admin') }}">@lang('general.Espace Admin')</a>
    @endif
</nav>

<main class="py-4">
            @yield('content')
</main>

<footer>
    <p>@lang('general.footer')</p>
</footer>

</body>

</html>