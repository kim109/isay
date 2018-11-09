<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:url"         content="{{ Request::url() }}" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="현 시국에 대한 국민의 생각" />
    <meta property="og:description" content="자신의 생각을 공유하여 국민의 힘을 그들에게 전달 할 수 있습니다" />

    <title>현황</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ elixir('css/report.css') }}">
  </head>

  <body>
  <script>
  window.fbAsyncInit = function() {
      FB.init({
        appId      : '1275240355881117',
        xfbml      : true,
        version    : 'v2.8'
        });
    };

        (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/ko_KR/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
    </script>
    <div class="container">
      <ul class="nav nav-tabs">
        <li role="presentation" @if (Request::is('report/korea')) class="active" @endif><a href="{{ url('report/korea') }}">대한민국</a></li>
        <li role="presentation" @if (Request::is('report/world')) class="active" @endif><a href="/report/world">전세계</a></li>
      </ul>

      <div id="share">
        <div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
          <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}&amp;src=sdkpreparse">공유하기</a>
        </div>
      </div>
      <div style="margin:2vh 0;">
        {{ date('m/d H:i') }} 현재<br>
        <h4 id="count" class="text-left" style="font-weight: bold;"></h4>
      </div>

      @yield('content')
      <div class="text-center">
        <a class="btn btn-default" href="https://play.google.com/store/apps/details?id=kr.co.wish.everyone" target="_blank" role="button">
            <i class="fa fa-android" aria-hidden="true"></i> 안드로이드 투표하기
        </a>
        <a class="btn btn-default" href="/isay" role="button">
            <i class="fa fa-apple" aria-hidden="true"></i> 아이폰 투표하기
        </a>
      </div>
    </div>

    <script src="//d3js.org/d3.v4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/topojson/1.6.20/topojson.min.js"></script>
    <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
@stack('scripts')
  </body>
</html>
