<!DOCTYPE html>
<html>
    <head>
        <title>Lens</title>

        <link href="https://fonts.lug.ustc.edu.cn/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }

            a {
                color: #000;
                text-decoration: none
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Lens</div>
                <p id="async">一言不合，贴代码</p>
            </div>
        </div>
        <script type="text/javascript">
        function async($json) {
            document.getElementById("async").innerHTML = "<a href=\"http://hitokoto.us/view/"+$json['id']+".html\">"+$json['hitokoto']+"</a>";
        }
        setTimeout(function(){
            var hjs=document.createElement('script');
            hjs.setAttribute('src','http://api.hitokoto.us/rand?encode=jsc&fun=async&length=20');
            document.body.appendChild(hjs);
        },100);
        </script>
    </body>
</html>
