<!DOCTYPE html>
<html lang="{{setting('language','en')}}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{setting('app_name')}} | {{setting('app_short_description')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" type="image/png" href="{{$app_logo}}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">

    <!-- Ionicons -->
    {{--<link href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" rel="stylesheet">--}}
    {{--<!-- iCheck -->--}}
    {{--<link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">--}}
    {{--<!-- select2 -->--}}
    {{--<link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">--}}
    <!-- Morris chart -->
    {{--<link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">--}}
    <!-- jvectormap -->
    {{--<link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">--}}
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <!-- Daterange picker -->
    {{--<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">--}}
    {{--<!-- bootstrap wysihtml5 - text editor -->--}}
    {{--<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">--}}

    @stack('css_lib')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-sweetalert/sweetalert.css')}}">
    {{--<!-- Bootstrap -->--}}
    {{--<link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}">--}}

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/'.setting("theme_color","primary").'.css')}}">
    @yield('css_custom')


        <!-- text box style-->

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">

    <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        #body{
           

        }
        #center-text {          
          display: flex;
          flex: 1;
          flex-direction:column; 
          justify-content: center;
          align-items: center;  
          height:100%;

      }
      #chat-circle {
          position: fixed;
          bottom: 50px;
          right: 50px;
          background:#fd8148;
          width: 80px;
          height: 80px;  
          border-radius: 50%;
          color: white;
          padding: 28px;
          cursor: pointer;
          box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.6), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
      }

      .btn#my-btn {
         background: white;
         padding-top: 13px;
         padding-bottom: 12px;
         border-radius: 45px;
         padding-right: 40px;
         padding-left: 40px;
         color: #5865C3;
     }
     #chat-overlay {
        background: rgba(255,255,255,0.1);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: none;
    }


    .chat-box {
      display:none;
      background: #efefef;
      position:fixed;
      right:30px;
      bottom:50px;  
      width:350px;
      max-width: 85vw;
      max-height:100vh;
      border-radius:5px;  
      /*   box-shadow: 0px 5px 35px 9px #464a92; */
      box-shadow: 0px 5px 35px 9px #ccc;
  }
  .chat-box-toggle {
      float:right;
      margin-right:15px;
      cursor:pointer;
  }
  .chat-box-header {
      background:#fd8148 ;
      height:60px;
      border-top-left-radius:5px;
      border-top-right-radius:5px; 
      color:white;
      text-align:center;
      font-size:20px;
      padding-top:17px;
  }
  .chat-box-body {
      position: relative;  
      height:370px;  
      height:auto;
      border:1px solid #ccc;  
      overflow: hidden;

  }
  .chat-box-body:after {
      content: "";
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
      opacity: 0.1;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      height:100%;
     /* position: absolute;*/
      z-index: 11000;   
  }
  #chat-input {
      background: #f4f7f9;
      width:100%; 
      position:relative;
      height:47px;  
      padding-top:10px;
      padding-right:50px;
      padding-bottom:10px;
      padding-left:15px;
      border:none;
      resize:none;
      outline:none;
      border:1px solid #ccc;
      color:#888;
      border-top:none;
      border-bottom-right-radius:5px;
      border-bottom-left-radius:5px;
      overflow:hidden;  
  }
  .chat-input > form {
    margin-bottom: 0;
}
#chat-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #ccc;
}
#chat-input::-moz-placeholder { /* Firefox 19+ */
  color: #ccc;
}
#chat-input:-ms-input-placeholder { /* IE 10+ */
  color: #ccc;
}
#chat-input:-moz-placeholder { /* Firefox 18- */
  color: #ccc;
}
.chat-submit {  
  position:absolute;
  bottom:3px;
  right:10px;
  background: transparent;
  box-shadow:none;
  border:none;
  border-radius:50%;
  color:#fd8148 ;
  width:35px;
  height:35px;  
}
.chat-logs {
  padding:15px; 
  height:280px;
  overflow-y:scroll;
}

.chat-logs::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar
{
    width: 5px;  
    background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar-thumb
{
    background-color: #5A5EB9;
}



@media only screen and (max-width: 500px) {
   .chat-logs {
    height:40vh;
}
}

.chat-msg.user > .msg-avatar img {
  width:45px;
  height:45px;
  border-radius:50%;
  float:left;
  width:15%;
}
.chat-msg.self > .msg-avatar img {
  width:45px;
  height:45px;
  border-radius:50%;
  float:right;
  width:15%;
}
.cm-msg-text {
  background:white;
  padding:10px 15px 10px 15px;  
  color:#666;
  max-width:75%;
  float:left;
  margin-left:10px; 
  position:relative;
  margin-bottom:20px;
  border-radius:30px;
}
.chat-msg {
  clear:both;    
}
.chat-msg.self > .cm-msg-text {  
  float:right;
  margin-right:10px;
  background: #5A5EB9;
  color:white;
}
.cm-msg-button>ul>li {
  list-style:none;
  float:left;
  width:50%;
}
.cm-msg-button {
    clear: both;
    margin-bottom: 70px;
}
</style>
<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
}
</script>
</head>

<body style="height: 100%; background-color: #f9f9f9;" class="hold-transition sidebar-mini {{setting('theme_color')}}">
    @if(auth()->check())
    <div class="wrapper">
        <!-- Main Header -->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand {{setting('fixed_header','')}} {{setting('nav_color','navbar-light bg-white')}} border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{url('dashboard')}}" class="nav-link">{{trans('lang.dashboard')}}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @if(env('APP_CONSTRUCTION',false))
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#"><i class="fa fa-info-circle"></i>
                    {{env('APP_CONSTRUCTION','') }}</a>
                </li>
                @endif
                @can('carts.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('carts*') ? 'active' : '' }}" href="{!! route('carts.index') !!}"><i class="fa fa-shopping-cart"></i></a>
                </li>
                @endcan
                @can('notifications.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}" href="{!! route('notifications.index') !!}"><i class="fa fa-bell"></i></a>
                </li>
                @endcan
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{auth()->user()->getFirstMediaUrl('avatar','icon')}}" class="brand-image mx-2 img-circle elevation-2" alt="User Image">
                        <i class="fa fa fa-angle-down"></i> {!! auth()->user()->name !!}

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('users.profile')}}" class="dropdown-item"> <i class="fa fa-user mr-2"></i> {{trans('lang.user_profile')}} </a>
                        <div class="dropdown-divider"></div>
                        <a href="{!! url('/logout') !!}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-envelope mr-2"></i> {{__('auth.logout')}}
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div id="body"> 
<!-- 
        <div id="chat-circle" class="btn btn-raised" style="display: none;">
            <div id="chat-overlay"></div>
            <i class="material-icons">speaker_phone</i>
        </div> -->

        <div class="chat-box" style="display:none;z-index:99999">
            <div class="chat-box-header">
              {!! auth()->user()->name !!}
              <span class="chat-box-toggle"><i class="material-icons">close</i></span>
          </div>
          <div class="chat-box-body">
              <div class="chat-box-overlay">   
              </div>
              <div class="chat-logs">

              <!--     <div id="cm-msg-1" class="chat-msg self" style="">
                    <span class="msg-avatar">           
                       <img src="https://image.crisp.im/avatar/operator/196af8cc-f6ad-4ef7-afd1-c45d5231387c/240/?1483361727745">         
                   </span>              
               </div> -->
           </div><!--chat-log -->
       </div>
       <div class="chat-input">      
          <form>
            @csrf
            <input type="text" id="chat-input" placeholder="Send a message..." name="msg">
           <!--  <input type="hidden" id="outgoing_msg_id" value="{{(isset($user->id)) ? $user->id:''}}">
            <input type="hidden" id="incoming_msg_id" value="1"> -->
            <button type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
        </form>      
    </div>
</div>

</div>


<!--message end-->
<div class="content-wrapper">
    @yield('content')
</div>

<!-- Main Footer -->
<footer class="main-footer {{setting('fixed_footer','')}}">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> {{implode('.',str_split(substr(config('installer.currentVersion','v100'),1,3)))}}
    </div>
    <strong>Copyright © {{date('Y')}} <a href="{{url('/')}}">{{setting('app_name')}}</a>.</strong> All rights reserved.
</footer>

</div>
@else
<nav class="nmain-header navbar navbar-expand {{setting('nav_color','navbar-light bg-white')}} border-bottom">
    <div class="container">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{!! url('/') !!}">{{setting('app_name')}}</a>
            </li>
            @include('layouts.menu',['icons'=>false])
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    {!! Auth::user()->name !!}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('users.profile')}}" class="dropdown-item"> <i class="fa fa-user mr-2"></i> Profile </a>
                    <div class="dropdown-divider"></div>
                    <a href="{!! url('/logout') !!}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-envelope mr-2"></i> {{__('auth.logout')}}
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>








<div id="page-content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
        <!-- Main Footer -->
        <footer class="{{setting('fixed_footer','')}}">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> {{implode('.',str_split(substr(config('installer.currentVersion','v100'),1,3)))}}
            </div>
            <strong>Copyright © {{date('Y')}} <a href="{{url('/')}}">{{setting('app_name')}}</a>.</strong> All rights reserved.
        </footer>
    </div>
</div>

@endrole


<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script id="rendered-js">

   $( document ).ready(function() 
   {
       $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    }); 
});

    var msg ='';
    var outgoing_msg_id ='1';
    var incoming_msg_id ='';
    function myFunction(id) {
        incoming_msg_id= id;
      //  alert(incoming_msg_id);
       $("#chat-circle").toggle('scale');
       $(".chat-box").toggle('scale');

          $.ajax({
        url:"pre_message",
        type: 'POST',
        data:{id:incoming_msg_id},
        success: function(response) {
            $(".chat-logs").html(response);
          //  alert(response)
        },
        error:function(data){
        }
    });
   }

   $(function () {
      var INDEX = 0;
      $("#chat-submit").click(function (e) {
        alert("hi");
        e.preventDefault();
         msg = $("#chat-input").val();
        if (msg.trim() == '') {
          return false;
      }

      $.ajax({
        //url: base_url + "send",
        url:"send",
        type: 'POST',
        data:{msg:msg,outgoing_msg_id:outgoing_msg_id,incoming_msg_id:incoming_msg_id},
        success: function(response) {
        },
        error:function(data){
        }
    });

      generate_message(msg, 'self');
      var buttons = [
      {
          name: 'Existing User',
          value: 'existing' },

          {
              name: 'New User',
              value: 'new' }];


              // setTimeout(function () {
              //     generate_message(msg, 'user');
              // }, 1000);

          });

      function generate_message(msg, type) {
        INDEX++;
        var str = "";
        str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + "\">";
        str += "          <span class=\"msg-avatar\">";
        str += "            <img src='http://app.proximeal.com/public/storage/app/public/69/conversions/106427_man_512x512-icon.jpg'>";
        str += "          <\/span>";
        str += "          <div class=\"cm-msg-text\">";
        str += msg;
        str += "          <\/div>";
        str += "        <\/div>";
        $(".chat-logs").append(str);
        $("#cm-msg-" + INDEX).hide().fadeIn(300);
        if (type == 'self') {
          $("#chat-input").val('');
      }
      $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
  }

  function generate_button_message(msg, buttons) {
    /* Buttons should be object array 
      [
        {
          name: 'Existing User',
          value: 'existing'
        },
        {
          name: 'New User',
          value: 'new'
        }
      ]
      */
      INDEX++;
      var btn_obj = buttons.map(function (button) {
          return "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\"" + button.value + "\">" + button.name + "<\/a><\/li>";
      }).join('');
      var str = "";
      str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg user\">";
      str += "          <span class=\"msg-avatar\">";
      str += "            <img src=\"https:\/\/image.crisp.im\/avatar\/operator\/196af8cc-f6ad-4ef7-afd1-c45d5231387c\/240\/?1483361727745\">";
      str += "          <\/span>";
      str += "          <div class=\"cm-msg-text\">";
      str += msg;
      str += "          <\/div>";
      str += "          <div class=\"cm-msg-button\">";
      str += "            <ul>";
      str += btn_obj;
      str += "            <\/ul>";
      str += "          <\/div>";
      str += "        <\/div>";
      $(".chat-logs").append(str);
      $("#cm-msg-" + INDEX).hide().fadeIn(300);
      $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
      $("#chat-input").attr("disabled", true);
  }

  $(document).delegate(".chat-btn", "click", function () {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'self');
});

  $("#chat-circle").click(function () {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
});

  $(".chat-box-toggle").click(function () {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
});

});
//# sourceURL=pen.js
</script>


<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script src="{{asset('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js')}}"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
{{--$.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="{{asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-app.js')}}"></script>

<script src="{{asset('https://www.gstatic.com/firebasejs/7.2.0/firebase-messaging.js')}}"></script>

<script type="text/javascript">@include('vendor.notifications.init_firebase')</script>

<script type="text/javascript">
    const messaging = firebase.messaging();
    navigator.serviceWorker.register("{{url('firebase/sw-js')}}")
    .then((registration) => {
        messaging.useServiceWorker(registration);
        messaging.requestPermission()
        .then(function() {
            console.log('Notification permission granted.');
            getRegToken();

        })
        .catch(function(err) {
            console.log('Unable to get permission to notify.', err);
        });
        messaging.onMessage(function(payload) {
            console.log("Message received. ", payload);
            notificationTitle = payload.data.title;
            notificationOptions = {
                body: payload.data.body,
                icon: payload.data.icon,
                image:  payload.data.image
            };
            Audio('{{asset('sound/notification.mp3')}}');
            audio.play();
            var notification = new Notification(notificationTitle,notificationOptions);
        });
    });

    function getRegToken(argument) {
        messaging.getToken().then(function(currentToken) {
            if (currentToken) {
                saveToken(currentToken);
                console.log(currentToken);
            } else {
                console.log('No Instance ID token available. Request permission to generate one.');
            }
        })
        .catch(function(err) {
            console.log('An error occurred while retrieving token. ', err);
        });
    }


    function saveToken(currentToken) {
        $.ajax({
            type: "POST",
            data: {'device_token': currentToken, 'api_token': '{!! auth()->user()->api_token !!}'},
            url: '{!! url('api/users',['id'=>auth()->id()]) !!}',
            success: function (data) {

            },
            error: function (err) {
                console.log(err);
            }
        });
    }
</script>

<!-- Sparkline -->
{{--<script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
{{--<!-- iCheck -->--}}
{{--<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>--}}
{{--<!-- select2 -->--}}
{{--<script src="{{asset('plugins/select2/select2.min.js')}}"></script>--}}
<!-- jQuery Knob Chart -->
{{--<script src="{{asset('plugins/knob/jquery.knob.js')}}"></script>--}}
<!-- daterangepicker -->
{{--<script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js')}}"></script>--}}
{{--<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>--}}
<!-- datepicker -->
<script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
{{--<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>--}}
<!-- Slimscroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-sweetalert/sweetalert.min.js')}}"></script>
<!-- FastClick -->
{{--<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>--}}
@stack('scripts_lib')
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
{{--<!-- AdminLTE dashboard demo (This is only for demo purposes) -->--}}
{{--<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>

<script src="{{asset('js/scripts.js')}}"></script>
@stack('scripts')





</body>
</html>