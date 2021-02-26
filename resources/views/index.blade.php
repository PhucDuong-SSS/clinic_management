<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phòng khám NTP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
    body{
        margin: 0;
        padding: 0;
        background: url("{{asset('indexImage.png')}}") no-repeat;
        background-size: cover;
    }
    .clinic{

        text-align: center;


    }
    .clinic__name {
        font-family: 'Poppins', sans-serif;
        top: 20%;
        left: 50%;
        position: absolute;
    }
    .clinic__name .clinic__title{
        font-weight: bolder;
        font-size: 40px;
        letter-spacing: 3px;
        color: #009432;

    }
    .clinic__name .clinic__brand{
        font-size: 50px;
        font-weight: bold;
        letter-spacing: 2px;
        color: #e74c3c;
    }

    .clinic a{
        position: absolute;
        top: 45%;
        left: 65%;
    }
    .btn {
        color: #009432;
        cursor: pointer;
        font-size: 16px;
        font-weight: 400;
        line-height: 45px;
        margin: 0 0 2em;
        max-width: 160px;
        position: relative;
        text-decoration: none;
        text-transform: uppercase;
        text-align: center;
        width: 100%;
    }
    .clinic__button {
        border: 1px solid;
        overflow: hidden;
        position: relative;
    }
    .clinic__button span {
        font-family: 'Poppins', sans-serif;
        z-index: 20;
    }
    .clinic__button:after {
         background: #fff;
         content: "";
         height: 155px;
         left: -75px;
         opacity: .2;
         position: absolute;
         top: -50px;
         transform: rotate(35deg);
         transition: all 550ms cubic-bezier(0.19, 1, 0.22, 1);
         width: 50px;
         z-index: -10;
     }

    .clinic__button:hover:after {

         left: 120%;
         transition: all 550ms cubic-bezier(0.19, 1, 0.22, 1);
    }
    .clinic a:hover{
        color: #27ae60;
    }

</style>
<body>
    <div class="clinic">
        <div class="clinic__name">
        <h1 class="clinic__title">Phòng khám Đa khoa</h1>
        <br>
        <h1 class="clinic__brand">NGUYỄN TRI PHƯƠNG</h1>
        </div>
        <a href="{{route("login")}}" class="btn clinic__button"><span>Đăng nhập</span></a>

    </div>



</body>
</html>
