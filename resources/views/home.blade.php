@extends('layouts.app')
@section('content')
<header>
    <div class="container">
        <div class="header_bar d-flex justify-content-between">
            <div class="header_logo">
                <img src="{{asset('img/vatan.svg')}}" alt="Site logo">
            </div>
            <div class="header_reg_and_login d-flex align-items-center justify-content-between">
                <div class="login_button">
                    <a href="{{'login'}}">Вход</a>
                </div>
                <div class="reg_button">
                    <a href="{{route('registration')}}">Регистрация</a>
                </div>
            </div>
            <div class="mobile_nav_button d-flex align-items-center justify-content-between flex-column">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
<section class="welcome">
    <div class="container">
        <div class="welcome_vatan d-flex align-items-center justify-content-between">
            <div class="welcome_vatan_info">
                <div class="welcome_vatan_title">
                    <h1>Вас приветствует
                        портал <span>Vatan</span></h1>
                </div>
                <div class="welcome_vatan_description">
                    <p>
                        С другой стороны, понимание сути ресурсосберегающих технологий требует от нас анализа соответствующих условий активизации! Мы вынуждены отталкиваться от того
                    </p>
                </div>
            </div>
            <div class="welcome_vatan_logo">
                <img src="{{asset('img/vatan_logo_welcome_block.svg')}}" alt="Welcome logo">
            </div>
        </div>
        <div class="welcome_reg_and_login">
            <div class="header_reg_and_login d-flex align-items-center">
                <div class="reg_button">
                    <a href="{{route('registration')}}">Регистрация</a>
                </div>
                <div class="login_button">
                    <a href="{{route('login')}}">Вход</a>
                </div>
            </div>
        </div>
        <div class="welcome_vatan_video_info">
            <div class="welcome_vatan_video_title">
                Больше информации в <span>видео</span>
            </div>
            <div class="welcome_vatan_video_player">
                <div class="welcome_vatan_video_play  d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/video_image.jpg)">{{asset('img/video_image.jpg')}}</div>
                <div class="player_icon">
                    <img src="{{asset('img/player_icon.svg')}}" alt="Player">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


