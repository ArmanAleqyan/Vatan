<!DOCTYPE html>
<html lang="EN">
<head>
    <title>Регистрация</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--	<link rel="stylesheet" href="./assets/css/bvselect.css">-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.media.css')}}">
    <link rel="stylesheet" href="{{asset('css/foopicker.css')}}">
</head>
<body>
<header>
    <div class="container">
        <div class="header_bar d-flex justify-content-between">
            <div class="header_logo">
                <img src="{{asset('img/vatan.svg')}}" alt="Site logo">
            </div>
            <div class="language_change">
                <select id="lang">
                    <option value="ru" data-icon="{{asset('img/ru.svg')}}" selected="selected">Russian</option>
                    <option value="en" data-icon="{{asset('img/tj.svg')}}">Tajikistan</option>
                    <option value="fr" data-icon="{{asset('img/uz.svg')}}">Uzbekistan</option>
                    <option value="fr" data-icon="{{asset('img/kg.svg')}}">Kyrgyzstan</option>
                </select>
                <div class="selected_leng"></div>
                <div class="language_select"></div>
            </div>
        </div>
    </div>
</header>
<section class="block_style reg_style">
    <div class="container">
        <div class="form_block_title">
            Регистрация
        </div>
        <div class="form_block_description">
            Регистрация стоит 1000 рублей, <span>которая будет на твоём счету</span> на любые услуги
        </div>
        <div class="form_block">
            <div class="form_input_change d-flex align-items-center justify-content-between">
                <div class="form_input_phone d-flex align-items-center justify-content-center active click_change_form" data-info="phone" data-type="number" data-placeholder="Номер телефона">
                    Номер телефона
                </div>
                <div class="form_input_email d-flex align-items-center justify-content-center click_change_form" data-info="email" data-type="email" data-placeholder="Эл. почта">
                    Эл. почта
                </div>
            </div>
            <form action="{{route('registration.store')}}" method="post">
                @csrf
                <div class="__input">
                    <input type="number" name="number" placeholder="Номер телефона" class="change_input_email_and_phone">
                </div>
                <div class="__input">
                    <input type="text" name="name" placeholder="Имя">
                </div>
                <div class="__input">
                    <input name="surname" type="text" placeholder="Фамилия">
                </div>
                <div class="__input">
                    <input name="patronymic" type="text" placeholder="Отчество">
                </div>
                <div class="__input">
                    <input name="date_of_birth" type="text" placeholder="Дата Рождения" id="datepicker">
                </div>
                <div class="__input">
                    <input name="city" type="text" placeholder="Страна">
                </div>
                <div class="__input">
                    <input name="username" type="text" placeholder="Юзернейм">
                </div>
                <div class="__input view_password_parent">
                    <div class="view_password">
                        <img src="{{asset('img/icon.svg')}}" alt="">
                    </div>
                    <input name="password" type="password" placeholder="Пароль">
                </div>
                <div class="__input view_password_parent">
                    <div class="view_password">
                        <img src="{{asset('img/icon.svg')}}" alt="">
                    </div>
                    <input name="password_confirmation" type="password" placeholder="Повтор пароля">
                </div>
                <div class="politic_checkbox">
                    <div class="item">
                        <div class="checkbox-rect">
                            <input type="checkbox" id="checkbox-rect1" name="check">
                            <label for="checkbox-rect1">Ознакомлен с договором-офертой</label>
                        </div>
                    </div>
                </div>
                <div class="form_submit d-flex align-items-center justify-content-center">
                    <button
                            type="submit" data-id="reg">
                        Зарегистрироваться
                    </button>
                </div>
                <div class="profile_info_and_login">
                    Уже есть аккаунт? <a href="{{route('login')}}">Войти</a>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal" id="reg">
    <div class="modal_body">
        <div class="modal__"></div>
        <div class="modal_body_info">
            <div class="close_modal">
                &#x2715
            </div>
            <div class="modal_title">
                Подтверждение аккаунта
            </div>
            <div class="modal_description">
                Мы отправим 4-х значный код на вашу эл.почту для подтверждения личности
            </div>
            <div class="input_block">
                <div class="__input">
                    <input type="text" placeholder="Код подтверждения">
                </div>
            </div>
            <div class="form_submit d-flex align-items-center justify-content-center">
                <button>
                    Подтвердить
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {

        var foopicker = new FooPicker({
            id: 'datepicker',
            dateFormat: 'MM/dd/yyyy'
        });

    });
</script>

<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/foopicker.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
</body>
</html>
