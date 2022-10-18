<!DOCTYPE html>
<html lang="EN">
<head>
    <title>Вход</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/media.css')}}">
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
<section>
    <div class="container">
        <div class="form_block login_layout_padding">
            <div class="form_block_title">
                Вход
            </div>
            <div class="form_input_change d-flex align-items-center justify-content-between">
                <div class="form_input_phone d-flex align-items-center justify-content-center active click_change_form"
                     data-info="phone" data-type="number" data-placeholder="Номер телефона">
                    Номер телефона
                </div>
                <div class="form_input_email d-flex align-items-center justify-content-center click_change_form"
                     data-info="email" data-type="email" data-placeholder="Эл. почта">
                    Эл. почта
                </div>
            </div>
            <form action="{{route('login.store')}}" method="post">
                @csrf
                <div class="__input">
                    <input type="number" name="number" placeholder="Номер телефона"
                           class="change_input_email_and_phone">
                </div>
                <div class="__input view_password_parent">
                    <div class="view_password">
                        <img src="{{asset('img/icon.svg')}}" alt="">
                    </div>
                    <input type="password" placeholder="Пароль" name="password">
                </div>
                <div class="resset_password_form d-flex align-items-center justify-content-end">
                    <a href="#" class="modal_click" type="button" data-id="login">Забыли пароль?</a>
                </div>
                <div class="form_submit d-flex align-items-center justify-content-center">
                    <button type="submit">
                        Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="modal" id="login">
    <div class="modal_body">
        <div class="modal__"></div>
        <div class="modal_body_info">
            <div class="close_modal">
                &#x2715
            </div>
            <div class="modal_title">
                Восстановление аккаунта
            </div>
            <div class="modal_description modal_desc modal_phone__ active">
                Мы отправим 4-х значный код на ваш тел. номер для подтверждения личности
            </div>
            <div class="modal_description modal_desc modal_email__">
                Мы отправили ссылку восстановления на вашу эл. почту
            </div>
            <div class="form_input_change d-flex align-items-center justify-content-between">
                <div class="form_input_phone d-flex align-items-center justify-content-center active click_change_form"
                     data-info="phone" data-type="number" data-placeholder="Номер телефона">
                    Номер телефона
                </div>
                <div class="form_input_email d-flex align-items-center justify-content-center click_change_form"
                     data-info="email" data-type="email" data-placeholder="Эл. почта">
                    Эл. почта
                </div>
            </div>
            <form action="">
                <div class="__input">
                    <input type="number" placeholder="Номер телефона" class="change_input_email_and_phone">
                </div>
            </form>
            <div class="form_submit d-flex align-items-center justify-content-center">
                <button class="modal_click" type="button" data-id="login_phone">
                    Далее
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="login_phone">
    <div class="modal_body">
        <div class="modal__"></div>
        <div class="modal_body_info">
            <div class="close_modal">
                &#x2715
            </div>
            <div class="modal_title">
                Восстановление аккаунта
            </div>
            <div class="modal_description">
                Введите код подтверждения
            </div>
            <div class="input_block">
                <div class="__input">
                    <input type="text" placeholder="Код подтверждения">
                </div>
            </div>
            <div class="form_submit d-flex align-items-center justify-content-center">
                <button class="modal_click" type="button" data-id="reset_password">
                    Подтвердить
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="reset_password">
    <div class="modal_body">
        <div class="modal__"></div>
        <div class="modal_body_info">
            <div class="close_modal">
                &#x2715
            </div>
            <div class="modal_title">
                Восстановление аккаунта
            </div>
            <div class="modal_description">
                Придумайте сложный пароль,содержащий
                строчные и прописные буквы,а так же цифры
                и символы
            </div>
            <div class="input_block">
                <div class="__input view_password_parent">
                    <div class="view_password">
                        <img src="{{asset('img/icon.svg')}}" alt="">
                    </div>
                    <input type="text" placeholder="Новый пароль">
                </div>
            </div>
            <div class="input_block">
                <div class="__input view_password_parent">
                    <div class="view_password">
                        <img src="{{asset('img/icon.svg')}}" alt="">
                    </div>
                    <input type="text" placeholder="Новый пароль">
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

<script src="{{asset('js/script.js')}}"></script>
</body>
</html>
