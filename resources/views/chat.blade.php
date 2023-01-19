<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

    html,
    body,
    div,
    span {
        /*height: 100%;*/
        width: 100%;
        overflow: hidden;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    .MessageCount{
        margin-left: 20px !important;
        min-width: 20px !important;

    }

    .NameSurname{
        white-space: pre !important;
        overflow: hidden !important;
    }


    .ixsButton::before {
        content: '\2715';
        position: absolute;
        top: -6px;
        right: -33px;
        color: #f30c0c;
        font-size: large;
        color: red;
        font-weight: bold;
    }

    body {
        background-color: #7e7e7e;
        /*background: url("http://shurl.esy.es/y") no-repeat fixed center;*/
        background-size: cover;
    }

    .fa-2x {
        font-size: 1.5em;
    }

    .app {
        position: relative;
        overflow: hidden;
        top: 10px;
        height: calc(100% - 38px);
        margin: auto;
        padding: 0;
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
    }

    .app-one {
        background-color: #f7f7f7;
        height: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
    }

    .side {
        padding: 0;
        margin: 0;
        height: 100%;
    }

    .side-one {
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        z-index: 1;
        position: relative;
        display: block;
        top: 0;
    }

    .side-two {
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        z-index: 2;
        position: relative;
        top: -100%;
        left: -100%;
        -webkit-transition: left 0.3s ease;
        transition: left 0.3s ease;

    }


    .heading {
        padding: 10px 16px 10px 15px;
        margin: 0;
        height: 60px;
        width: 100%;
        background-color: #eee;
        z-index: 1000;
    }

    .heading-avatar {
        padding: 0;
        cursor: pointer;

    }

    .heading-avatar-icon img {
        border-radius: 50%;
        height: 40px;
        width: 40px;
    }

    .heading-name {
        padding: 0 !important;
        cursor: pointer;
    }

    .heading-name-meta {
        font-weight: 700;
        font-size: 100%;
        padding: 5px;
        padding-bottom: 0;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000;
        display: block;
    }

    .heading-online {
        display: none;
        padding: 0 5px;
        font-size: 12px;
        color: #93918f;
    }

    .heading-compose {
        padding: 0;
    }

    .heading-compose i {
        text-align: center;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }

    .heading-dot {
        padding: 0;
        margin-left: 10px;
    }

    .heading-dot i {
        text-align: right;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }

    .searchBox {
        padding: 0 !important;
        margin: 0 !important;
        height: 60px;
        width: 100%;
    }

    .searchBox-inner {
        height: 100%;
        width: 100%;
        padding: 10px !important;
        background-color: #eeeeee;
    }


    /*#searchBox-inner input {
      box-shadow: none;
    }*/

    .searchBox-inner input:focus {
        outline: none;
        border: none;
        box-shadow: none;
    }

    .sideBar {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #eee !important;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 58px);
    }

    .sideBar-body {
        position: relative;
        padding: 10px !important;
        border-bottom: 1px solid #f7f7f7;
        height: 72px;
        margin: 0 !important;
        cursor: pointer;
    }

    .sideBar-body:hover {
        background-color: #f2f2f2;
    }

    .sideBar-avatar {
        text-align: center;
        padding: 0 !important;
    }

    .avatar-icon img {
        border-radius: 50%;
        height: 49px;
        width: 49px;
    }

    .sideBar-main {
        padding: 0 !important;
    }

    .sideBar-main .row {
        padding: 0 !important;
        margin: 0 !important;
    }

    .sideBar-name {
        padding: 10px !important;
    }

    .name-meta {
        font-size: 100%;
        padding: 1% !important;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000;
    }

    .sideBar-time {
        padding: 10px !important;
    }

    .time-meta {
        text-align: right;
        font-size: 12px;
        padding: 1% !important;
        color: rgba(0, 0, 0, .4);
        vertical-align: baseline;
    }

    /*New Message*/

    .newMessage {
        padding: 0 !important;
        margin: 0 !important;
        height: 100%;
        position: relative;
        left: -100%;
    }

    .newMessage-heading {
        padding: 10px 16px 10px 15px !important;
        margin: 0 !important;
        height: 100px;
        width: 100%;
        background-color: #00bfa5;
        z-index: 1001;
    }

    .newMessage-main {
        padding: 10px 16px 0 15px !important;
        margin: 0 !important;
        height: 60px;
        margin-top: 30px !important;
        width: 100%;
        z-index: 1001;
        color: #fff;
    }

    .newMessage-title {
        font-size: 18px;
        font-weight: 700;
        padding: 10px 5px !important;
    }

    .newMessage-back {
        text-align: center;
        vertical-align: baseline;
        padding: 12px 5px !important;
        display: block;
        cursor: pointer;
    }

    .newMessage-back i {
        margin: auto !important;
    }

    .composeBox {
        padding: 0 !important;
        margin: 0 !important;
        height: 60px;
        width: 100%;
    }

    .composeBox-inner {
        height: 100%;
        width: 100%;
        padding: 10px !important;
        background-color: #fbfbfb;
    }

    .composeBox-inner input:focus {
        outline: none;
        border: none;
        box-shadow: none;
    }

    .compose-sideBar {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #fff;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 160px);
    }

    /*Conversation*/

    .conversation {
        padding: 0 !important;
        margin: 0 !important;
        /*height: 100%;*/
        height: calc(100% - -55px);
        /*width: 100%;*/
        border-left: 1px solid rgba(0, 0, 0, .08);
        /*overflow-y: auto;*/
    }

    .message {
        padding: 8px !important;
        margin: 0 !important;
        background-color: #eeeeee;
        /*background: url("w.jpg") no-repeat fixed center;*/
        background-size: cover;
        overflow-y: auto;
        border: 1px solid #f7f7f7;
        height: calc(100% - 172px);
    }

    .message-previous {
        margin: 0 !important;
        padding: 0 !important;
        height: auto;
        width: 100%;
    }

    .previous {

        font-size: 15px;
        text-align: center;
        padding: 10px !important;
        cursor: pointer;
    }

    .previous a {
        text-decoration: none;
        font-weight: 700;
    }

    .message-body {
        margin: 0 !important;
        padding: 0 !important;
        width: auto;
        height: auto;
    }

    .message-main-receiver {
        padding: 3px 20px;
        max-width: 60%;
    }

    .message-main-sender {
        padding: 3px 20px !important;
        margin-left: 40% !important;
        max-width: 60%;
    }

    .message-text {
        max-width: 288px;
        margin: 0 !important;
        padding: 5px !important;
        word-wrap: break-word;
        font-weight: 200;
        font-size: 14px;
        padding-bottom: 0 !important;
    }

    .message-time {
        margin: 0 !important;
        margin-left: 50px !important;
        font-size: 12px;
        text-align: right;
        color: #9a9a9a;

    }

    .receiver {
        /*max-width: 100%;*/
        /*max-width: 20%;*/
        width: auto !important;
        padding: 4px 10px 7px !important;
        border-radius: 10px 10px 10px 0;
        /*background: 0 1px 1px rgb(238 238 238);*/
        font-size: 12px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
        word-wrap: break-word;
        display: inline-block;
        background-color: white;
    }

    .sender {
        max-width: 100%;
        float: right;
        width: auto !important;
        background: #dcf8c6;
        border-radius: 10px 10px 0 10px;
        padding: 4px 10px 7px !important;
        font-size: 12px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
        display: inline-block;
        word-wrap: break-word;
    }


    /*Reply*/

    .reply {
        height: 60px;
        width: 100%;
        /*background-color: #221d1d;*/
        background-color: #f5f1ee;
        padding: 10px 5px 10px 5px !important;
        margin: 0 !important;
        z-index: 1000;
    }

    .reply-emojis {
        padding: 5px !important;
    }

    .reply-emojis i {
        text-align: center;
        padding: 5px 5px 5px 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-recording {
        padding: 5px !important;
    }

    .reply-recording i {
        text-align: center;
        padding: 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-send {
        padding: 5px !important;
    }

    .reply-send i {
        text-align: center;
        padding: 5px !important;
        color: #93918f;
        cursor: pointer;
    }

    .reply-main {
        padding: 2px 5px !important;
    }

    .reply-main textarea {
        /*background-color: #221d1d;*/
        width: 100%;
        resize: none;
        overflow-x: hidden;
        padding: 5px !important;
        outline: none;
        border: none;
        text-indent: 5px;
        /*box-shadow: none;*/
        height: 100%;
        border: 1px solid;
        font-size: 16px;
    }

    .reply-main textarea:focus {
        /*background-color: #221d1d;*/
        border: 1px solid;
        outline: none;
        /*border: none;*/
        text-indent: 5px;
        box-shadow: none;
    }

    @media screen and (max-width: 700px) {
        .app {
            top: 0;
            height: 100%;
        }

        .heading {
            height: 70px;
            background-color: #009688;
        }

        .fa-2x {
            font-size: 2.3em !important;
        }

        .heading-avatar {
            padding: 0 !important;
        }

        .heading-avatar-icon img {
            height: 50px;
            width: 50px;
        }

        .heading-compose {
            padding: 5px !important;
        }

        .heading-compose i {
            color: #fff;
            cursor: pointer;
        }

        .heading-dot {
            padding: 5px !important;
            margin-left: 10px !important;
        }

        .heading-dot i {
            color: #fff;
            cursor: pointer;
        }

        .sideBar {
            height: calc(100% - 130px);
        }

        .sideBar-body {
            height: 80px;
        }

        .sideBar-avatar {
            text-align: left;
            padding: 0 8px !important;
        }

        .avatar-icon img {
            height: 55px;
            width: 55px;
        }

        .sideBar-main {
            padding: 0 !important;
        }

        .sideBar-main .row {
            padding: 0 !important;
            margin: 0 !important;
        }

        .sideBar-name {
            padding: 10px 5px !important;
        }

        .name-meta {
            font-size: 16px;
            padding: 5% !important;
        }

        .sideBar-time {
            padding: 10px !important;
        }

        .time-meta {
            text-align: right;
            font-size: 14px;
            padding: 4% !important;
            color: rgba(0, 0, 0, .4);
            vertical-align: baseline;
        }

        /*Conversation*/
        .conversation {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            /*width: 100%;*/
            border-left: 1px solid rgba(0, 0, 0, .08);
            /*overflow-y: auto;*/
        }

        .message {
            height: calc(100% - 140px);
        }

        .reply {
            height: 70px;
        }

        .reply-emojis {
            padding: 5px 0 !important;
        }

        .reply-emojis i {
            padding: 5px 2px !important;
            font-size: 1.8em !important;
        }

        .reply-main {
            padding: 2px 8px !important;
        }

        .reply-main textarea {
            background-color: #221d1d;
            padding: 8px !important;
            font-size: 18px;
        }

        .reply-recording {
            padding: 5px 0 !important;
        }

        .reply-recording i {
            padding: 5px 0 !important;
            font-size: 1.8em !important;
        }

        .reply-send {
            padding: 5px 0 !important;
        }

        .reply-send i {
            padding: 5px 2px 5px 0 !important;
            font-size: 1.8em !important;
        }


    }
</style>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div style="display: flex;margin-left: 93px;">
    <a style="    display: flex;  justify-content: start;color: black; margin: 0" href="https://dev.vatan.su/nova/dashboards/main">Вернутса в Админ Панел</a>
</div>
    <div class="container app">



    <div class="row app-one">
        <div class="col-sm-4 side">
            <div class="side-one">
                {{--                <div class="row heading">--}}
                {{--                    <div class="col-sm-3 col-xs-3 heading-avatar">--}}
                {{--                        <div class="heading-avatar-icon">--}}
                {{--                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png">--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-sm-1 col-xs-1  heading-dot  pull-right">--}}
                {{--                        <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>--}}
                {{--                    </div>--}}
                {{--                    <div class="col-sm-2 col-xs-2 heading-compose  pull-right">--}}
                {{--                        <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="row searchBox">
                    <div class="col-sm-12 searchBox-inner">
                        <div class="form-group has-feedback">
                            <input id="searchText" type="text" class="form-control" name="searchText"
                                   placeholder="Поиск">
                            {{--                            <span class="glyphicon glyphicon-search form-control-feedback"></span>--}}
                        </div>
                    </div>
                </div>

                <div class="row sideBar">
                    @foreach($right_side_data as $right_side_datas)
                        <div class="row sideBar-body" data_id="{{$right_side_datas['room_id']}}"
                             receiver_id="{{$right_side_datas['receiver_id']}}">
                            <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                <div class="avatar-icon">
                                    <img src="{{asset('uploads/'.$right_side_datas['user_image'])}}">
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-9 sideBar-main">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta" style="display: flex"><p
                              class="NameSurname">{{$right_side_datas['user_name']. ' '.$right_side_datas['surname']   .' '}}</p> &ensp;
                        @if($right_side_datas['count'] > 0)
                          <span class="MessageCount"
                                style="background-color: #7caf7b; border-radius: 50%; display: flex; justify-content: center; align-items: center; width: 20px; height: 20px"> {{$right_side_datas['count']}}
                      </span>
                      @endif
                </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                       <span class="time-meta pull-right">
{{--                           {{$right_side_datas['time']}}--}}
                            <time class="timeago"
                                  datetime="{{$right_side_datas['time']}}">  {{$right_side_datas['time']}}</time>

                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>

            <div class="side-two">
                <div class="row newMessage-heading">
                    <div class="row newMessage-main">
                        <div class="col-sm-2 col-xs-2 newMessage-back">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </div>
                        <div class="col-sm-10 col-xs-10 newMessage-title">
                            New Chat
                        </div>
                    </div>
                </div>

                <div class="row composeBox">
                    <div class="col-sm-12 composeBox-inner">
                        <div class="form-group has-feedback">
                            <input id="composeText" type="text" class="form-control" name="searchText"
                                   placeholder="Search People">

                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                </div>

                <div class="row compose-sideBar">
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sideBar-body">
                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta">John Doe
                </span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                  <span class="time-meta pull-right">18:18
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8 conversation CloseMessageBlock">
            <div style="display: flex;justify-content: center; padding-top: 150px;">
                <p style="background-color: #0f172a; color: white ; border-radius: 14px ; width: 273px; height: 39px; text-align: center; ">
                    <span style="display: flex; justify-content: center; margin-top: 9px;">Выберите, кому хотели бы написать </span>
                </p>
            </div>
        </div>
        <div class="col-sm-8 conversation OpenMessageBlock " style="display: none">
            <div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        {{--                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png">--}}
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta" href="">John Doe
                    </a>
                    <span class="heading-online">Online</span>
                </div>
                {{--                <div class="col-sm-1 col-xs-1  heading-dot pull-right">--}}
                {{--                    <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>--}}
                {{--                </div>--}}
            </div>

            <div
                    style="display: grid;
                    align-items: end;"
                    class="row message " id="conversation">


                <div class=" row message-previous">
                </div>
                <div
                        style="overflow: initial"
                        class=" row message-body">

                </div>
            </div>
            <form action="" id="MessageForm">
                <div class="row reply">

                    <div class="col-sm-9 col-xs-9 reply-main " style="width: 83% !important; ">
                        <div style=" display: flex ;column-gap: 6px; " id="newDivqwe"></div>
                        <textarea class="form-control" rows="1"  id="comment"></textarea>
                        <input type="hidden" name="receiver_id">
                        <input type="hidden" name="room_id">
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-recording">
                        <label for="file"><i class="fa fa-file fa-2x" aria-hidden="true"></i></label>
                        <input multiple="multiple" type="file" name="file[]" style="display: none;" id="file"
                               >
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-send">
                        <i class="fa fa-send fa-2x" aria-hidden="true" id="sendButton"></i>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- timeago JS -->
<script src="{{asset('admin/jquery.timeago.js')}}"></script>
<script>
    $("time.timeago").timeago();
    FullUrl = 'https://dev.vatan.su/';
    let DataArray = [];



    $(document).on('input', '#searchText', function (event) {
            // Stop form from submitting normally
            event.preventDefault();
            let search = $(this).val()
            let formData = new FormData();
            formData.append('search', search)
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "getAdminMessageJson",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,
            encode: true,
            success: function(response){
                                            $('.sideBar').html(' ')
                            $.each(response.data, function (index, value) {
                                var cond = '';
                                let asd = $('[name="room_id"]').val();
                                let CountT = '';
                                if (value.count > 0) {
                                    CountT = '<span class="MessageCount" style="background-color: ' +
                                        '#7caf7b; border-radius: ' +
                                        '50%; display: flex; ' +
                                        'justify-content: center; ' +
                                        'align-items: center; width: 20px; height: 20px"> ' +
                                        ` ${value.count} `
                                    ' </span>';


                                }
                                if (value.room_id == asd) {
                                    var cond = 'background-color:  rgba(147, 147, 147, 0.55);';
                                    CountT = '';
                                }
                                $('.sideBar').append(
                                    `
<div class="row sideBar-body"  style="${cond}" data_id="${value.room_id}" receiver_id="${value.receiver_id}">
                            <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                <div class="avatar-icon">
                                    <img src="https://dev.vatan.su/uploads/${value.user_image}">
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-9 sideBar-main">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta" style="display: flex"><p class="NameSurname">${value.user_name} ${value.surname}</p> &ensp;
                    ${CountT}
                </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                       <span class="time-meta pull-right">

                            <time class="timeago" datetime="${value.time}">  ${value.time}</time>

                </span>
                                    </div>
                                </div>
                            </div>
                        </div> `)

            });
                $("time.timeago").timeago();
                $(".sideBar-body").click(function (event) {
                    // Stop form from submitting normally

                    event.preventDefault();
                    let img = $(this).children().children(2).html();
                    $(".reply-main").css('width', '83%');
                    $(".reply-recording").show();

                    let NameSurname = $(this).find('.NameSurname').text();
                    let MessageCount = $(this).find('.MessageCount').css('display', 'none');
                    $('.heading-avatar-icon').html(' ').append(img);
                    var room_id = $(this).attr("data_id");

                    localStorage.setItem('room_id',room_id);



                    var receiver_id = $(this).attr("receiver_id");
                    $('.sideBar-body').css('background-color', '#eeeeee');
                    $(this).css('background-color', 'rgb(147 147 147 / 55%)');
                    let formData = new FormData();
                    formData.append('room_id', room_id);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "Post",
                        url: FullUrl + 'getRoomChat',
                        data: formData,
                        dataType: "json",
                        processData: false, // Не позволять jQuery обрабатывать мой file_obj
                        contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                        cache: false,
                        encode: true,
                        success: function (response) {
                            $('.CloseMessageBlock').css('display', 'none');
                            $('.OpenMessageBlock ').css('display', 'block');
                            let main_div = $('.message-body');
                            main_div.html(' ');
                            $('[name="receiver_id"]').val(receiver_id);
                            $('[name="room_id"]').val(room_id);
                            $('#comment').val('');
                            let newHref = "https://dev.vatan.su/nova/resources/users/"+receiver_id;
                            $('.heading-name-meta').attr('href', newHref);
                            $('.heading-name-meta').text(NameSurname);


                            $.each(response.data, function (index, value) {
                                if (value.receiver_id == 1) {
                                    let messageDiv = '';
                                    if(value.file != null) {
                                        let fileType = value.file.split(".");
                                        let type = fileType[fileType.length - 1];
                                        if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                            messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                        } else {
                                            messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                        }
                                    }
                                    if(value.messages != null){
                                        main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                        <div class="receiver" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                    }

                                    main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                                } else {
                                    let messageDiv = '';
                                    if(value.file != null) {
                                        let fileType = value.file.split(".");
                                        let type = fileType[fileType.length - 1];
                                        if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                            messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                        } else {
                                            messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                'justify-content: end;  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                        }
                                    }
                                    if(value.messages != null){
                                        main_div.append(`
                        <div class="col-sm-12 message-main-sender bis_skin_checked="1">
                        <div class="sender" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                    }
                                    main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">
                                            ${messageDiv}
                        </div>`)
                                }
                                $("time.timeago").timeago();
                                $(document).ready(function () {
                                    $('#conversation').animate({
                                        scrollTop: $('#conversation')[0].scrollHeight
                                    }, 0);
                                });


                                $('img').attr('loading', 'lazy');

                            });
                        }
                    });

                });
            }

        });



    });








    $(document).on('keydown', function(event) {
        if (event.keyCode === 27) {
            $('.CloseMessageBlock').css('display', 'block');
            $('.OpenMessageBlock ').css('display', 'none');
            var value = localStorage.getItem("room_id");
            let element = document.querySelector(`.sideBar-body[data_id="${value}"]`);
            element.style.backgroundColor = "";
            localStorage.removeItem('room_id')
        }
    });


    $(document).ready(function () {
        var value = localStorage.getItem("room_id");
            if(value != null){
                var div = document.querySelector(`div[data_id="${value}"]`);
                div.click();
            }
    });


    $(".sideBar-body").click(function (event) {
        // Stop form from submitting normally

        event.preventDefault();
        let img = $(this).children().children(2).html();
        $(".reply-main").css('width', '83%');
        $(".reply-recording").show();

        let NameSurname = $(this).find('.NameSurname').text();
        let MessageCount = $(this).find('.MessageCount').css('display', 'none');
        $('.heading-avatar-icon').html(' ').append(img);
        var room_id = $(this).attr("data_id");

        localStorage.setItem('room_id',room_id);



        var receiver_id = $(this).attr("receiver_id");
        $('.sideBar-body').css('background-color', '#eeeeee');
        $(this).css('background-color', 'rgb(147 147 147 / 55%)');
        let formData = new FormData();
        formData.append('room_id', room_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "Post",
            url: FullUrl + 'getRoomChat',
            data: formData,
            dataType: "json",
            processData: false, // Не позволять jQuery обрабатывать мой file_obj
            contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
            cache: false,
            encode: true,
            success: function (response) {
                $('.CloseMessageBlock').css('display', 'none');
                $('.OpenMessageBlock ').css('display', 'block');
                let main_div = $('.message-body');
                main_div.html(' ');
                $('[name="receiver_id"]').val(receiver_id);
                $('[name="room_id"]').val(room_id);
                $('#comment').val('');
                let newHref = "https://dev.vatan.su/nova/resources/users/"+receiver_id;
                $('.heading-name-meta').attr('href', newHref);
                $('.heading-name-meta').text(NameSurname);


                $.each(response.data, function (index, value) {
                    if (value.receiver_id == 1) {
                        let messageDiv = '';
                        if(value.file != null) {
                            let fileType = value.file.split(".");
                            let type = fileType[fileType.length - 1];
                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                    '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                            } else {
                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                    '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                    '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                            }
                        }
                        if(value.messages != null){
                            main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                        <div class="receiver" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                        }

                        main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                    } else {
                        let messageDiv = '';
                        if(value.file != null) {
                            let fileType = value.file.split(".");
                            let type = fileType[fileType.length - 1];
                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                    '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                            } else {
                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                    'justify-content: end;  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                    '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                            }
                        }
                        if(value.messages != null){
                            main_div.append(`
                        <div class="col-sm-12 message-main-sender bis_skin_checked="1">
                        <div class="sender" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                        }
                        main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">
                                            ${messageDiv}
                        </div>`)
                    }
                    $("time.timeago").timeago();
                    $(document).ready(function () {
                        $('#conversation').animate({
                            scrollTop: $('#conversation')[0].scrollHeight
                        }, 0);
                    });


                        $('img').attr('loading', 'lazy');

                });
            }
        });

    });

    // $(document).on('keydown','#comment',function(event){
    //     event.preventDefault();
    //     if(event.keyCode == 13) {
    //         $('#MessageForm').submit();
    //     }
    // });



    $(document).on('keydown', '#comment', function (event) {
        if (event.keyCode == 13) {
            // Stop form from submitting normally
            event.preventDefault();
            // $('#MessageForm').submit();
            let receiver_id = $('[name="receiver_id"]').val();
            let room_id = $('[name="room_id"]').val();
            let message = $('#comment').val();

            // console.log(DataArray.length)
            let DataArrayLenght = DataArray.length;
            var numFiles = $('input[type="file"]')[0].files.length;
            let formData = new FormData();
            if (message != '' || numFiles > 0) {
                $('#comment').val('');
                for (var i = 0; i < DataArrayLenght; i++) {
                    formData.append('file[]', DataArray[i]);
                }
                $("#newDivqwe").html(' ')
                $("#comment").show()
                $("#comment").removeAttr('disabled', 'disabled')
                formData.append('receiver_id', receiver_id);
                formData.append('messages', message);
                formData.append('room_id', room_id);
                $(".reply-recording").show();
                $("#file").val("");
                $(".reply-main").css('width', '83%');
                $(".reply-recording").show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "Post",
                    url: FullUrl + 'SendAdminMessage',
                    data: formData,
                    dataType: "json",
                    processData: false, // Не позволять jQuery обрабатывать мой file_obj
                    contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                    cache: false,
                    encode: true,
                    success: function (response) {
                        DataArray = []

                        let messageDiv = '';
                        $.each(response.data.chat, function (index, value) {
                            if (value.messages != null) {
                                messageDiv = '<div class="sender" bis_skin_checked="1"> ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    `${value.messages}` +
                                    '     </div>'
                                let main_div = $('.message-body');
                                main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">

                            ${messageDiv}
                            <span class="message-time pull-right">
                   <time class="timeago" datetime="${value.created_at}">${value.created_at}</time>

              </span>
                        </div>
                    </div>`)
                            } else if (value.file != null) {
                                let fileType = value.file.split(".");
                                let type = fileType[fileType.length - 1];
                                if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                    messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                        ' <div class="message-text" bis_skin_checked="1">' +
                                        ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                        '     </div>'
                                } else {
                                    messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                        ' <div class="message-text" bis_skin_checked="1">' +
                                        '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                        '    justify-content: end;" class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                        '     </div>'
                                }

                                $('#comment').val('');
                                let main_div = $('.message-body');
                                main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">

                            ${messageDiv}
                            <span class="message-time pull-right">
                   <time class="timeago" datetime="${value.created_at}">${value.created_at}</time>

              </span>
                        </div>
                    </div>`)


                            }

                        });


                        $("time.timeago").timeago();
                        $(document).ready(function () {
                            $('#conversation').animate({
                                scrollTop: $('#conversation')[0].scrollHeight
                            }, 0);
                        });

                        let main_divUser = $('.sideBar');
                        let div = $(`div[data_id=${room_id}]`);
                        $(`div[data_id=${room_id}]`).remove()
                        main_divUser.prepend(div)
                        // $('.sideBar').html(' ')
//                     $.ajax({
//                         headers: {
//                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                         },
//                         type: "POST",
//                         url: FullUrl + 'getAdminMessageJson',
//                         // data: formData,
//                         dataType: "json",
//                         processData: false, // Не позволять jQuery обрабатывать мой file_obj
//                         contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
//                         cache: false,
//                         encode: true,
//                         success: function (response) {
//                             $('.sideBar').html(' ')
//                             $.each(response.data, function (index, value) {
//                                 var cond = '';
//                                 let asd = $('[name="room_id"]').val();
//                                 let CountT = '';
//                                 if (value.count > 0) {
//                                     CountT = '<span class="MessageCount" style="background-color: ' +
//                                         '#7caf7b; border-radius: ' +
//                                         '50%; display: flex; ' +
//                                         'justify-content: center; ' +
//                                         'align-items: center; width: 20px; height: 20px"> ' +
//                                         ` ${value.count} `
//                                     ' </span>';
//
//
//                                 }
//                                 if (value.room_id == asd) {
//                                     var cond = 'background-color:  rgba(147, 147, 147, 0.55);';
//                                     CountT = '';
//                                 }
//                                 main_divUser.append(
//                                     `
// <div class="row sideBar-body"  style="${cond}" data_id="${value.room_id}" receiver_id="${value.receiver_id}">
//                             <div class="col-sm-3 col-xs-3 sideBar-avatar">
//                                 <div class="avatar-icon">
//                                     <img src="https://dev.vatan.su/uploads/${value.user_image}">
//                                 </div>
//                             </div>
//                             <div class="col-sm-9 col-xs-9 sideBar-main">
//                                 <div class="row">
//                                     <div class="col-sm-8 col-xs-8 sideBar-name">
//                   <span class="name-meta" style="display: flex"><p class="NameSurname">${value.user_name} ${value.surname}</p> &ensp;
//                     ${CountT}
//                 </span>
//                                     </div>
//                                     <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
//                        <span class="time-meta pull-right">
//
//                             <time class="timeago" datetime="${value.time}">  ${value.time}</time>
//
//                 </span>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div> `)
//
//
//                             });
//
//
                        $(".sideBar-body").click(function (event) {
                            // Stop form from submitting normally

                            event.preventDefault();
                            $(".reply-main").css('width', '83%');
                            $(".reply-recording").show();
                            let img = $(this).children().children(2).html();


                            let NameSurname = $(this).find('.NameSurname').text();
                            let MessageCount = $(this).find('.MessageCount').css('display', 'none');
                            $('.heading-avatar-icon').html(' ').append(img);
                            var room_id = $(this).attr("data_id");
                            var receiver_id = $(this).attr("receiver_id");
                            $('.sideBar-body').css('background-color', '#eeeeee');
                            $(this).css('background-color', 'rgb(147 147 147 / 55%)');
                            let formData = new FormData();
                            formData.append('room_id', room_id);
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "Post",
                                url: FullUrl + 'getRoomChat',
                                data: formData,
                                dataType: "json",
                                processData: false, // Не позволять jQuery обрабатывать мой file_obj
                                contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                                cache: false,
                                encode: true,
                                success: function (response) {
                                    $('.CloseMessageBlock').css('display', 'none');
                                    $('.OpenMessageBlock ').css('display', 'block');
                                    let main_div = $('.message-body');
                                    main_div.html(' ');
                                    $('[name="receiver_id"]').val(receiver_id);
                                    $('[name="room_id"]').val(room_id);
                                    $('#comment').val('');
                                    $('.heading-name-meta').text(NameSurname);


                                    $.each(response.data, function (index, value) {
                                        if (value.receiver_id == 1) {
                                            let messageDiv = '';
                                            if(value.file != null) {
                                                let fileType = value.file.split(".");
                                                let type = fileType[fileType.length - 1];
                                                if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                                    messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                        ' <div class="message-text" bis_skin_checked="1">' +
                                                        ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                        '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                                } else {
                                                    messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                        ' <div class="message-text" bis_skin_checked="1">' +
                                                        '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                        '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                        '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                                }
                                            }
                                            if(value.messages != null){
                                                main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                        <div class="receiver" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                            }

                                            main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                                        } else {
                                            let messageDiv = '';
                                            if(value.file != null) {
                                                let fileType = value.file.split(".");
                                                let type = fileType[fileType.length - 1];
                                                if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                                    messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                        ' <div class="message-text" bis_skin_checked="1">' +
                                                        ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                        '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                                } else {
                                                    messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                        ' <div class="message-text" bis_skin_checked="1">' +
                                                        '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                        'justify-content: end;  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                        '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                                }
                                            }
                                            if(value.messages != null){
                                                main_div.append(`
                        <div class="col-sm-12 message-main-sender bis_skin_checked="1">
                        <div class="sender" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                            }
                                            main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">
                                            ${messageDiv}
                        </div>`)
                                        }
                                        $("time.timeago").timeago();
                                        $(document).ready(function () {
                                            $('#conversation').animate({
                                                scrollTop: $('#conversation')[0].scrollHeight
                                            }, 0);
                                        });
                                    });
                                }
                            });

                        });
                    }
                });
                // }
                // });
            }
        }
    });

    $("#sendButton").click(function (event) {
        // Stop form from submitting normally
        event.preventDefault();
        // $('#MessageForm').submit();
        let receiver_id = $('[name="receiver_id"]').val();
        let room_id = $('[name="room_id"]').val();
        let message = $('#comment').val();

        // console.log(DataArray.length)
        let DataArrayLenght = DataArray.length;
        var numFiles = $('input[type="file"]')[0].files.length;
        let formData = new FormData();
        if (message != '' || numFiles > 0) {
            $('#comment').val('');
            for (var i = 0; i < DataArrayLenght; i++) {
                formData.append('file[]', DataArray[i]);
            }
            $("#newDivqwe").html(' ')
            $("#comment").show()
            $("#comment").removeAttr('disabled', 'disabled')
            formData.append('receiver_id', receiver_id);
            formData.append('messages', message);
            formData.append('room_id', room_id);
            $(".reply-recording").show();
            $("#file").val("");
            $(".reply-main").css('width', '83%');
            $(".reply-recording").show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "Post",
                url: FullUrl + 'SendAdminMessage',
                data: formData,
                dataType: "json",
                processData: false, // Не позволять jQuery обрабатывать мой file_obj
                contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                cache: false,
                encode: true,
                success: function (response) {
                    DataArray = []

                    let messageDiv = '';
                    $.each(response.data.chat, function (index, value) {
                        if (value.messages != null) {
                            messageDiv = '<div class="sender" bis_skin_checked="1"> ' +
                                ' <div class="message-text" bis_skin_checked="1">' +
                                `${value.messages}` +
                                '     </div>'
                            let main_div = $('.message-body');
                            main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">

                            ${messageDiv}
                            <span class="message-time pull-right">
                   <time class="timeago" datetime="${value.created_at}">${value.created_at}</time>

              </span>
                        </div>
                    </div>`)
                        } else if (value.file != null) {
                            let fileType = value.file.split(".");
                            let type = fileType[fileType.length - 1];
                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                    '     </div>'
                            } else {
                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                    '    justify-content: end;" class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                    '     </div>'
                            }

                            $('#comment').val('');
                            let main_div = $('.message-body');
                            main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">

                            ${messageDiv}
                            <span class="message-time pull-right">
                   <time class="timeago" datetime="${value.created_at}">${value.created_at}</time>

              </span>
                        </div>
                    </div>`)


                        }

                    });


                    $("time.timeago").timeago();

                    $(document).ready(function () {
                        $('#conversation').animate({
                            scrollTop: $('#conversation')[0].scrollHeight
                        }, 1);
                    });

                    let main_divUser = $('.sideBar');
                    let div = $(`div[data_id=${room_id}]`);
                    $(`div[data_id=${room_id}]`).remove()
                    main_divUser.prepend(div)
                    // $('.sideBar').html(' ')
//                     $.ajax({
//                         headers: {
//                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                         },
//                         type: "POST",
//                         url: FullUrl + 'getAdminMessageJson',
//                         // data: formData,
//                         dataType: "json",
//                         processData: false, // Не позволять jQuery обрабатывать мой file_obj
//                         contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
//                         cache: false,
//                         encode: true,
//                         success: function (response) {
//                             $('.sideBar').html(' ')
//                             $.each(response.data, function (index, value) {
//                                 var cond = '';
//                                 let asd = $('[name="room_id"]').val();
//                                 let CountT = '';
//                                 if (value.count > 0) {
//                                     CountT = '<span class="MessageCount" style="background-color: ' +
//                                         '#7caf7b; border-radius: ' +
//                                         '50%; display: flex; ' +
//                                         'justify-content: center; ' +
//                                         'align-items: center; width: 20px; height: 20px"> ' +
//                                         ` ${value.count} `
//                                     ' </span>';
//
//
//                                 }
//                                 if (value.room_id == asd) {
//                                     var cond = 'background-color:  rgba(147, 147, 147, 0.55);';
//                                     CountT = '';
//                                 }
//                                 main_divUser.append(
//                                     `
// <div class="row sideBar-body"  style="${cond}" data_id="${value.room_id}" receiver_id="${value.receiver_id}">
//                             <div class="col-sm-3 col-xs-3 sideBar-avatar">
//                                 <div class="avatar-icon">
//                                     <img src="https://dev.vatan.su/uploads/${value.user_image}">
//                                 </div>
//                             </div>
//                             <div class="col-sm-9 col-xs-9 sideBar-main">
//                                 <div class="row">
//                                     <div class="col-sm-8 col-xs-8 sideBar-name">
//                   <span class="name-meta" style="display: flex"><p class="NameSurname">${value.user_name} ${value.surname}</p> &ensp;
//                     ${CountT}
//                 </span>
//                                     </div>
//                                     <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
//                        <span class="time-meta pull-right">
//
//                             <time class="timeago" datetime="${value.time}">  ${value.time}</time>
//
//                 </span>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div> `)
//
//
//                             });
//
//
                    $(".sideBar-body").click(function (event) {
                        // Stop form from submitting normally

                        event.preventDefault();
                        $(".reply-main").css('width', '83%');
                        $(".reply-recording").show();
                        let img = $(this).children().children(2).html();


                        let NameSurname = $(this).find('.NameSurname').text();
                        let MessageCount = $(this).find('.MessageCount').css('display', 'none');
                        $('.heading-avatar-icon').html(' ').append(img);
                        var room_id = $(this).attr("data_id");
                        var receiver_id = $(this).attr("receiver_id");
                        $('.sideBar-body').css('background-color', '#eeeeee');
                        $(this).css('background-color', 'rgb(147 147 147 / 55%)');
                        let formData = new FormData();
                        formData.append('room_id', room_id);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "Post",
                            url: FullUrl + 'getRoomChat',
                            data: formData,
                            dataType: "json",
                            processData: false, // Не позволять jQuery обрабатывать мой file_obj
                            contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                            cache: false,
                            encode: true,
                            success: function (response) {
                                $('.CloseMessageBlock').css('display', 'none');
                                $('.OpenMessageBlock ').css('display', 'block');
                                let main_div = $('.message-body');
                                main_div.html(' ');
                                $('[name="receiver_id"]').val(receiver_id);
                                $('[name="room_id"]').val(room_id);
                                $('#comment').val('');
                                $('.heading-name-meta').text(NameSurname);


                                $.each(response.data, function (index, value) {
                                    if (value.receiver_id == 1) {
                                        let messageDiv = '';
                                        if(value.file != null) {
                                            let fileType = value.file.split(".");
                                            let type = fileType[fileType.length - 1];
                                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                    ' <div class="message-text" bis_skin_checked="1">' +
                                                    ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                    '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                            } else {
                                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                    ' <div class="message-text" bis_skin_checked="1">' +
                                                    '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                    '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                    '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                            }
                                        }
                                        if(value.messages != null){
                                            main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                        <div class="receiver" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                        }

                                        main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                                    } else {
                                        let messageDiv = '';
                                        if(value.file != null) {
                                            let fileType = value.file.split(".");
                                            let type = fileType[fileType.length - 1];
                                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                    ' <div class="message-text" bis_skin_checked="1">' +
                                                    ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                    '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                            } else {
                                                messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                    ' <div class="message-text" bis_skin_checked="1">' +
                                                    '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                    'justify-content: end;  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                    '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                            }
                                        }
                                        if(value.messages != null){
                                            main_div.append(`
                        <div class="col-sm-12 message-main-sender bis_skin_checked="1">
                        <div class="sender" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                        }
                                        main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">
                                            ${messageDiv}
                        </div>`)
                                    }
                                    $("time.timeago").timeago();
                                    $(document).ready(function () {
                                        $('#conversation').animate({
                                            scrollTop: $('#conversation')[0].scrollHeight
                                        }, 0);
                                    });
                                });
                            }
                        });

                    });
                        }
                    });


                // }
            // });
        }
    });


    $(document).ready(function () {
        $("#comment").on('change keyup paste', function () {
            let lenght = $('#comment').val()
            if (lenght.length > 0) {
                $(".reply-recording").hide();
                $(".reply-main").css('width', '90%');
            } else {
                $(".reply-main").css('width', '83%');
                $(".reply-recording").show();
            }
        });
    });


    $(document).ready(function () {
        $("#file").on('change keyup paste', function () {
            var numFiles = $('input[type="file"]')[0].files.length;
            let allUndefined = DataArray;
            let myArray = DataArray;
            let filteredArray = myArray.filter(item => item !== undefined);
            let allLenght = numFiles +filteredArray.length;

            if (filteredArray.length > 10 || numFiles > 10 || allLenght > 10) {
                alert('Выберете  менше  10 фаилов')
            } else {
                $("#comment").attr("disabled", 'disabled');
                $("#comment").css("display", 'none');
                var file = $('input[type="file"]')[0].files.length;
                let time =  $.now();
                for (var i = 0; i < file; i++) {
                    let type = $("input[type='file']")[0].files[i].type.split('/')[0]
                    DataArray.push($("input[type='file']")[0].files[i]);

                    if (type == 'image') {
                        var fileUrl = URL.createObjectURL($("input[type='file']")[0].files[i]);
                        $("#newDivqwe").append(`
                        <div class="PhotoDiv" style='overflow: visible;position: relative; width: 40px; height: 40px'>
                        <button class="ixsButton" data-id="${DataArray.length-1}" style='
                                position: relative;
                                    outline: none;
                                    border: none;
                                position: relative;
                                '></button>
                        <img class='sendPhoto' style='width: 40px; height: 40px' src='${fileUrl}'/>
                        </div>`);
                    } else {
                        $("#newDivqwe").append("  " +
                            "" +
                            "  <div class='PhotoDiv' style='overflow: visible;position: relative; width: 40px; height: 40px'>\n   " +
                            "                     <button class=\"ixsButton\" data-id="+`${DataArray.length-1}`+" style='\n                                position: relative;\n                                    outline: none;\n                                    border: none;\n                                position: relative;\n                                '></button>" +
                            "<i class=\"fileType fa fa-file fa-3x\" aria-hidden=\"true\"> </i></div>")
                    }
                }
            }




            $(".ixsButton").click(function (event) {
                event.preventDefault()
                let data_id = $(this).attr('data-id')
                $(this).parent('.PhotoDiv').hide()
                DataArray.splice(data_id,1,undefined)
                let data = DataArray;


                let allUndefined = true;
                $.each(data, function(index, item) {
                    if (typeof item !== "undefined") {
                        allUndefined = false;
                        return false;
                    }
                });
                if (allUndefined) {
                    $("#comment").removeAttr("disabled", 'disabled');
                    $("#comment").css("display", 'block');
                }
            })

        });
    });




    Pusher.logToConsole = false;
    var pusher = new Pusher('82c41d8c09d510fed195', {
        cluster: 'ap2',
    });

    var channel = pusher.subscribe('chat');

    channel.bind('pusher:subscription_succeeded', function (members) {
        channel.bind("App\\Events\\ChatNotification", function (data) {
            let main_div = $('.message-body');
            let main_divUser = $('.sideBar');
            let sendEr = $('[name="receiver_id"]').val();

            if (data.chat.receiver_id == 1) {
                let main_div = $('.message-body');
                let asd = $('[name="room_id"]').val();

                if (data.chat.room_id == asd) {

                    if(data.chat.messages != null){
                        main_div.append(`
                      <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                          <div class="receiver" bis_skin_checked="1">
                              <div class="message-text" bis_skin_checked="1">
                                  ${data.chat.messages}
                              </div>
                              <span class="message-time pull-right">
                           <time class="timeago" datetime="${data.chat.created_at}">${data.chat.created_at}</time>

                              </span>
                          </div>
                         </div>`)
                    }

                    if(data.chat.file != null){
                        let messageDiv = '';
                            let fileType = data.chat.file.split(".");
                            let type = fileType[fileType.length - 1];
                            if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    ' <img width="200px" height="200px" src="uploads/' + `${data.chat.file}` + '">' +
                                    '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${data.chat.created_at}`+'">'+`${data.chat.created_at}`+' </time></span>'
                            } else {
                                messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                    ' <div class="message-text" bis_skin_checked="1">' +
                                    '<a href="uploads/' + `${data.chat.file}` + '" download=""> <i style="display: flex;\n' +
                                    '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                    '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${data.chat.created_at}`+'">'+`${data.chat.created_at}`+' </time> </span>'
                            }


                        main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                    }




                    let formDataUpdate = new FormData();
                    formDataUpdate.append('id', asd);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "Post",
                        url: FullUrl + 'UpdateStatusChat',
                        data: formDataUpdate,
                        dataType: "json",
                        processData: false, // Не позволять jQuery обрабатывать мой file_obj
                        contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                        cache: false,
                        encode: true,
                        success: function (response) {
                        }
                    });


                }


                $("time.timeago").timeago();
                $(document).ready(function () {
                    $('#conversation').animate({
                        scrollTop: $('#conversation')[0].scrollHeight
                    }, 1000);
                });


                if($('#searchText').val() == ''){
                    let main_divUser = $('.sideBar');
                    let div = $(`div[data_id=${data.chat.room_id}]`);
                    $(`div[data_id=${data.chat.room_id}]`).remove()
                    let CountT = '';


                    if (data.getCount > 0) {
                        CountT = '<span class="MessageCount" style="background-color: ' +
                            '#7caf7b; border-radius: ' +
                            '50%; display: flex; ' +
                            'justify-content: center; ' +
                            'align-items: center; width: 20px; height: 20px"> ' +
                            ` ${data.getCount} `
                        ' </span>';
                    }
                    if (data.chat.room_id == asd) {
                        var cond = 'background-color:  rgba(147, 147, 147, 0.55);';
                        CountT = '';
                    }
                    main_divUser.prepend(`<div class="row sideBar-body"  style="${cond}" data_id="${data.chat.room_id}" receiver_id="${data.user.id}">
                            <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                <div class="avatar-icon">
                                    <img src="https://dev.vatan.su/uploads/${data.user.avatar}">
                                </div>
                            </div>
                            <div class="col-sm-9 col-xs-9 sideBar-main">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-8 sideBar-name">
                  <span class="name-meta" style="display: flex"><p class="NameSurname">${data.user.name} ${data.user.surname}</p> &ensp;
                    ${CountT}
                </span>
                                    </div>
                                    <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                       <span class="time-meta pull-right">

                            <time class="timeago" datetime="${data.chat.created_at}">  ${data.lattestMessage}</time>

                </span>
                                    </div>
                                </div>
                            </div>
                        </div> `)
                }





//                 let main_divUser = $('.sideBar');
//                 $('.sideBar').html(' ')
//                 $.ajax({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     },
//                     type: "POST",
//                     url: FullUrl + 'getAdminMessageJson',
//                     // data: formData,
//                     dataType: "json",
//                     processData: false, // Не позволять jQuery обрабатывать мой file_obj
//                     contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
//                     cache: false,
//                     encode: true,
//                     success: function (response) {
//                         $('.sideBar').html(' ')
//                         $.each(response.data, function (index, value) {
//                             var cond = '';
//                             let asd = $('[name="room_id"]').val();
//                             let CountT = '';
//                             if (value.count > 0) {
//                                 CountT = '<span class="MessageCount" style="background-color: ' +
//                                     '#7caf7b; border-radius: ' +
//                                     '50%; display: flex; ' +
//                                     'justify-content: center; ' +
//                                     'align-items: center; width: 20px; height: 20px"> ' +
//                                     ` ${value.count} `
//                                 ' </span>';
//
//
//                             }
//                             if (value.room_id == asd) {
//                                 var cond = 'background-color:  rgba(147, 147, 147, 0.55);';
//                                 CountT = '';
//                             }
//                             main_divUser.append(
//                                 `
// <div class="row sideBar-body"  style="${cond}" data_id="${value.room_id}" receiver_id="${value.receiver_id}">
//                             <div class="col-sm-3 col-xs-3 sideBar-avatar">
//                                 <div class="avatar-icon">
//                                     <img src="https://dev.vatan.su/uploads/${value.user_image}">
//                                 </div>
//                             </div>
//                             <div class="col-sm-9 col-xs-9 sideBar-main">
//                                 <div class="row">
//                                     <div class="col-sm-8 col-xs-8 sideBar-name">
//                   <span class="name-meta" style="display: flex"><p class="NameSurname">${value.user_name} ${value.surname}</p> &ensp;
//                     ${CountT}
//                 </span>
//                                     </div>
//                                     <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
//                        <span class="time-meta pull-right">
//
//                             <time class="timeago" datetime="${value.time}">  ${value.time}</time>
//
//                 </span>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div> `)
//
//
//                         });
//
//
                $(".sideBar-body").click(function (event) {
                    // Stop form from submitting normally

                    event.preventDefault();
                    let img = $(this).children().children(2).html();
                    $(".reply-main").css('width', '83%');
                    $(".reply-recording").show();


                    let NameSurname = $(this).find('.NameSurname').text();
                    let MessageCount = $(this).find('.MessageCount').css('display', 'none');
                    $('.heading-avatar-icon').html(' ').append(  img);
                    var room_id = $(this).attr("data_id");
                    var receiver_id = $(this).attr("receiver_id");
                    $('.sideBar-body').css('background-color', '#eeeeee');
                    $(this).css('background-color', 'rgb(147 147 147 / 55%)');
                    let formData = new FormData();
                    formData.append('room_id', room_id);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "Post",
                        url: FullUrl + 'getRoomChat',
                        data: formData,
                        dataType: "json",
                        processData: false, // Не позволять jQuery обрабатывать мой file_obj
                        contentType: false, // Не позволять jQuery устанавливать запрошенный тип контента
                        cache: false,
                        encode: true,
                        success: function (response) {
                            $('.CloseMessageBlock').css('display', 'none');
                            $('.OpenMessageBlock ').css('display', 'block');
                            let main_div = $('.message-body');
                            main_div.html(' ');
                            $('[name="receiver_id"]').val(receiver_id);
                            $('[name="room_id"]').val(room_id);
                            $('#comment').val('');
                            $('.heading-name-meta').text(NameSurname);


                            $.each(response.data, function (index, value) {
                                if (value.receiver_id == 1) {
                                    let messageDiv = '';
                                    if(value.file != null) {
                                        let fileType = value.file.split(".");
                                        let type = fileType[fileType.length - 1];
                                        if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                            messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                        } else {
                                            messageDiv = ' <div style="background: #eeeeee;" class="receiver" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                '  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                        }
                                    }
                                    if(value.messages != null){
                                        main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                        <div class="receiver" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                    }

                                    main_div.append(`
                        <div class="col-sm-12 message-main-receiver" bis_skin_checked="1">
                                            ${messageDiv}


                        </div>`)
                                } else {
                                    let messageDiv = '';
                                    if(value.file != null) {
                                        let fileType = value.file.split(".");
                                        let type = fileType[fileType.length - 1];
                                        if (type == 'jpg' || type == 'png' || type == 'gif' || type == 'jpeg' || type == 'tif' || type == 'tiff') {
                                            messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                ' <img width="200px" height="200px" src="uploads/' + `${value.file}` + '">' +
                                                '     </div>     <span class="message-time pull-right"><time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time></span>'
                                        } else {
                                            messageDiv = ' <div style="background: #eeeeee;" class="sender" bis_skin_checked="1">   ' +
                                                ' <div class="message-text" bis_skin_checked="1">' +
                                                '<a href="uploads/' + `${value.file}` + '" download=""> <i style="display: flex;\n' +
                                                'justify-content: end;  " class="fa fa-file fa-5x" aria-hidden="true"> </i></a> ' +
                                                '     </div>     <span class="message-time pull-right"> <time  class="timeago" datetime="'+`${value.created_at}`+'">'+`${value.created_at}`+' </time> </span>'
                                        }
                                    }
                                    if(value.messages != null){
                                        main_div.append(`
                        <div class="col-sm-12 message-main-sender bis_skin_checked="1">
                        <div class="sender" bis_skin_checked="1">
                            <div class="message-text" bis_skin_checked="1">
                                ${value.messages}
                            </div>
                            <span class="message-time pull-right">
             <time  class="timeago" datetime="${value.created_at}">${value.created_at}</time>
              </span>
                        </div>
                    </div>`)
                                    }
                                    main_div.append(`
                        <div class="col-sm-12 message-main-sender" bis_skin_checked="1">
                                            ${messageDiv}
                        </div>`)
                                }
                                $("time.timeago").timeago();

                                $(document).ready(function () {
                                    $('#conversation').animate({
                                        scrollTop: $('#conversation')[0].scrollHeight
                                    }, 1);
                                });
                            });
                        }
                    });

                });
//                     }
//                 });


            }

        });
    });


    $(function () {
        $(".heading-compose").click(function () {
            $(".side-two").css({
                "left": "0"
            });
        });

        $(".newMessage-back").click(function () {
            $(".side-two").css({
                "left": "-100%"
            });
        });
    })
</script>

