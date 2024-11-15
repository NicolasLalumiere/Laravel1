@extends('layouts.app')


@section('content')



<div class="container">
<div class="row">
<div class="about-section">
    <h2>Nicolas Lalumiere</h2>
    <p>@lang('general.course'): 420-5H6 MO @lang('general.web_applications')</p>
    <p>@lang('general.fall_2024'), Collège Montmorency</p>
    
    <h3>@lang('general.navigation_bar')</h3>
    <p>
        @lang('general.in_navigation_bar_above') <strong>@lang('general.search_bar')</strong> 
        @lang('general.search_autocomplete_with_trip_in_db').
        @lang('general.search_only_not_logged_in')
    </p>

    <p>
        @lang('general.also_in_navigation_bar') <strong>@lang('general.languages')</strong>. 
        @lang('general.click_language_translate_all_texts').
    </p>
    
    <h3>@lang('general.signup_button')</h3>
    <p>
        @lang('general.signup_version_now_has_button'). 
        @lang('general.signup_redirects_to_form_encrypts_password').
        @lang('general.new_users_assigned_user_role').
        @lang('general.create_admin_modify_db_manually').
    </p>

    <h3>@lang('general.admin_features')</h3>
    <p>
        @lang('general.if_admin_logged_in') <strong>@lang('general.admin_space')</strong>
        @lang('general.admin_option_in_second_nav_bar').
        @lang('general.admin_can_see_all_trips_in_db_including_others').
    </p>

    <p>ADMIN: nic@test.com / nic12345!</p>

    <h3>@lang('general.image_requirements')</h3>
    <p>
        @lang('general.version_requires_image_on_trip_creation').
        @lang('general.cannot_create_trip_without_image').
        @lang('general.user_can_modify_trip_image').
    </p>

    <h3>@lang('general.database_diagram')</h3>
    <p>@lang('general.database_diagram_description'):</p>

    <img src="{{ asset('images/diagramme_DB.png') }}">

</div>
@endsection