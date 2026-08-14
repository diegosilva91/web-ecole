<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <title>Panel de mails</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
          integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    <style>
        body, table, tr, td {
            font-size: 13px;
        }

        h2, h3 {
            margin-top: 0;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 1em;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 0.8em;
        }

        .panel-heading h2 {
            margin-bottom: 0;
        }

        h3 {
            font-size: 14px;
            margin-bottom: 0.6em;
        }

        .column {
            margin-bottom: 2em;
        }

        input, select {
            font-size: 11px;
        }

        a, a:visited {
            text-decoration: none;
            color: #4F7BE3;
        }

        select {
            -webkit-appearance: menulist;
            -moz-appearance: menulist;
            appearance: auto;
        }

        .form-control {
            font-size: 12px;
        }

        .site {
            padding-bottom: 0.4em;
            margin-bottom: 0.8em;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class=" col-xs-12">
            <div class="row">

                <div class="column col-lg-4 col-xs-12">
                    <div class="panel panel-default panel-success">
                        <div class="panel-heading">
                            <h2>Mails transaccionales</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Mails de usuario</p>
                                    <ul>
                                        <li><a href="/test/mails/extern/welcome-user" target="resultado">Bienvenida usuario</a></li>
                                        <li><a href="/test/mails/extern/welcome-teacher" target="resultado">Bienvenida profesor</a></li>
                                        <li><a href="/test/mails/extern/completed-course" target="resultado">Curso completado</a></li>
                                        <li><a href="/test/mails/rextern/eminder/5" target="resultado">Recordatorio 5 días</a></li>
                                        <li><a href="/test/mails/extern/reminder/10" target="resultado">Recordatorio 10 días</a></li>
                                        <li><a href="/test/mails/extern/reminder/15" target="resultado">Recordatorio 15 días</a></li>
                                        <li><a href="/test/mails/extern/purchaseCard" target="resultado">Compra curso Tarjeta</a></li>
                                        <li><a href="/test/mails/extern/purchasePaypal" target="resultado">Compra curso Paypal</a></li>
                                        <li><a href="/test/mails/extern/purchaseTransfer" target="resultado">Compra curso Transferencia</a></li>
                                        <li><a href="/test/mails/extern/purchaseSepa" target="resultado">Compra curso SEPA</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Mails de Mi-empresa</p>
                                    <ul>
                                        <li><a href="#" target="resultado">Compra curso Tarjeta</a></li>
                                        <li><a href="#" target="resultado">Compra curso SEPA</a></li>
                                        <li><a href="#" target="resultado">Compra curso Paypal</a></li>
                                        <li><a href="#" target="resultado">Compra curso Transferencia</a></li>
                                    </ul>
                                </div>
                            </div>
                            -->
                            <div class="row center-block">
                                <iframe id="resultado" name="resultado" width="90%" height="50px" src=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
