<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <title>demo chat</title>
    <script>
        $(function(){
            document.cookie = '';
            function wsStart() {
                ws = new WebSocket("ws://127.0.0.1:8004/userId=" + Math.round(Math.random()*10000));
                ws.onopen = function() {
                    $("#chat").append("<p>系统：连接打开</p>");
                };

                ws.onclose = function() {
                    $("#chat").append("<p>系统：连接被关闭，尝试重新连接</p>");
                    setTimeout(wsStart, 1000);
                };

                ws.onmessage = function(evt) {
                    $("#chat").append("<p>"+evt.data+"</p>");
                };

            }

            wsStart();

            $('#chat').height($(window).height() - 80);

            $('#input').focus();
            console.log(ws);
        });

        // 自动提交
        function hello(){
            ws.send('wan');
            console.log(ws);
        }
        </script>
</head>

<body>
    <div class="navbar-fixed-bottom">
        <form onsubmit="hello(); $('#input').val(''); return false; " id="myform">
            <input id="input" type="text" class="form-control" placeholder="Text input" style="width: 100%;" maxlength="140" autocomplete="off">
        </form>
    </div>
</body>
</html>
