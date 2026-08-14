<!DOCTYPE html>
<html ⚡4email>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">
    <style type="text/css">
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }


        p,
        ul li,
        ol li,
        {
            font-size: 18px;
            font-family: 'Poppins';
            color: #262626;
        }

        h1 {
            font-size: 32px;
            text-align: center;
            line-height: 120%;
        }

        h2 {
            font-size: 26px;
            text-align: center;
            line-height: 120%;
        }

        h3 {
            font-size: 20px;
            text-align: center;
            line-height: 120%;
        }

        h1 a {
            font-size: 32px;
        }

        h2 a {
            font-size: 26px;
        }

        h3 a {
            font-size: 20px;
        }


        *[class="gmail-fix"] {
            display: none;
        }


        body {
            width: 100%;
            font-family: 'Poppins';
        }

        table {
            border-collapse: collapse;
            border-spacing: 0px;
        }

        table td,
        html,
        body,
        {
            padding: 0;
            margin: 0;
        }

        p,
        hr {
            margin: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 0;
            line-height: 120%;
            font-family: 'Poppins',"open sans", "helvetica neue", helvetica, arial, sans-serif;
        }


        a {
            font-family: "Poppins","open sans", "helvetica neue", helvetica, arial, sans-serif;
            text-decoration: none;
        }

        h1 {
            font-size: 36px;
            font-style: normal;
            font-weight: bold;
            color: #333333;
        }

        h1 a {
            font-size: 36px;
        }

        h2 {
            font-size: 30px;
            font-style: normal;
            font-weight: bold;
            color: #333333;
        }

        h2 a {
            font-size: 30px;
        }

        h3 {
            font-size: 18px;
            font-style: normal;
            font-weight: normal;
            color: #333333;
        }

        h3 a {
            font-size: 18px;
        }

        ul li,
        ol li {
            margin-bottom: 15px;
        }
    </style>

</head>

<body>
<div style="width: 100%; background-color: #eeeeee">
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: white;padding: 0;
    margin: 0;">
        <tr>
            <td valign="top">
                <table cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td align="center">
                            <table width="600" cellspacing="0" cellpadding="0"
                                   bgcolor="#ffffff" align="center">
                                <tr>
                                    <td style="padding-top: 40px; padding-right:25px; padding-left:25px;" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="530" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0"
                                                           role="presentation">
                                                        <tr>
                                                            <td align="center">
                                                                <p style="width: 547px;
                                                                font-family:  Poppins;
                                                                font-size: 24px;
                                                                font-weight: 300; text-align: center;
                                                                color: #262626;">¡Hola {{$user->name}}! 🎉<br>
                                                                    ¡Enhorabuena, has completado tu curso! 🚀</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="530" valign="top" align="center">
                                                    <p style="font-family: Poppins; font-size: 24px;font-weight: 500;text-align: center;">“{{$course->title}}”</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td style="cursor: pointer;" align="center">
                            <a style="text-decoration: underline;" href="{{url('es/reviews/'.$token)}}">
                                <img src="https://myawsmi-empresa.s3-eu-west-1.amazonaws.com/public/images/mails/link_reviews.png" style="margin-top:30px"/>
                            </a>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="530" valign="top" align="center">
                            <p style="font-family: Poppins; font-size: 18px;font-weight: 600;text-align: center;color: #29c0d3;margin-top:60px;">
                                Desde LifeCole queremos agradecerte tu interés y esperamos <br>que haya sido una experiencia única para ti y tus hij@s.
                            </p>
                            <p style="font-family: Poppins; font-size: 18px;font-weight: 400;text-align: center;color: #262626;margin-top:30px;">Si tienes ganas de más ¡Te recomendamos los siguientes <br>cursos para continuar con tu formación! </p>
                        </td>
                    </tr>
                </table>
        </tr>
        </td>
        </tr>

        <tr><td><table style="margin-top: 30px" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                    <tbody><tr>
                        <td style="padding-right: 25px; padding-left: 25px;" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                    <td width="530" valign="top" align="center">
                                        <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tbody><tr style="margin-top:36px;">
                                                <td style="padding-bottom: 10px;" align="center">
                                                        <a href='/es/cursos/programacion/programacion-educativa/programacion-para-nin-at-s-con-scratch' target="_blank"><img src="https://myawsmi-empresa.s3.eu-west-1.amazonaws.com/public/images/mails/card_code2.png"
                                                        ></a>
                                                </td>
                                                <td style="padding-bottom: 10px;" align="center">
                                                        <a href='/es/cursos/creacion-de-videojuegos/programacion-y-minecraft/aprende-a-programar-con-minecraft-nivel-2' target="_b"><img src="https://myawsmi-empresa.s3-eu-west-1.amazonaws.com/public/images/mails/card_game2.png" 
                                                        ></a>
                                                </td> 
                                                <td style="padding-bottom: 10px;" align="center">     
                                                        <a href='/es/cursos/robotica-educativa-y-profesional/robots-y-programacion/aprende-a-programar-con-arduino-y-abre-las-puertas-a-la-robotica' target="_b"><img src="https://myawsmi-empresa.s3-eu-west-1.amazonaws.com/public/images/mails/card_robot2.png"
                                                        ></a>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody></table>

                        </td>
                    </tr>
                    </tbody></table></td></tr>

        <tr><td><table style="margin-top: 70px;  width: 1018px;
                    background-color: #f5f5f5;" cellspacing="0" cellpadding="0"  align="center">
                    <tbody><tr>
                        <td style="padding-top: 40px; padding-right: 25px; padding-left: 25px;" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                    <td width="530" valign="top" align="center">
                                        <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tbody><tr>
                                                <td style="padding-bottom: 10px;" align="center">
                                                    <div style="margin-top: 36px;  font-size: 18px;">
                                                        <table style="float: center; margin-bottom: 71px">
                                                            <tr>
                                                                <td><p style="padding-bottom: 10px;"><span style="width:12px;
                                                                    margin-right: 20px;
                                                                    height: 51px;
                                                                    font-family: Poppins;
                                                                    font-size: 12px; color: #803a91;">&#9679;</span>En este <a style="text-decoration: underline;color: #29c0d3;
            font-weight: 500;" href="{{url('es/reviews/'.$token)}}">enlace</a> puedes dejarnos tu opinión ¡nos ayudarán a mejorar!</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p><span style="width: 12px;
                                                                    margin-right: 20px;
                                                                    height: 51px;
                                                                    font-family: Poppins;
                                                                    font-size: 12px; color: #803a91;">&#9679;</span>O si lo prefieres, sube tu story con el hastag <b>#Lifecoolers</b> y etiqueta
                                                                        a <b>mi-empresaedu</b>
                                                                    </p></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody></table>

                        </td>
                    </tr>
                    </tbody></table></td></tr>

        <tr><td><table style="margin-top:70px; background-color: #803a91; width: 100%" cellspacing="0" cellpadding="0" align="center">
                    <tbody><tr>
                        <td align="left" style="background-color: #803a91; padding-bottom: 34px; padding-top: 40px; padding-right: 25px; padding-left: 25px;">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                    <td width="530" valign="top" align="center">
                                        <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tbody><tr>
                                                <td style="padding-bottom: 10px;" align="center">
                                                    <div>
                                                        <center>
                                                            <p style="color:white">
                                                                Para cualquier otra pregunta, no dudes en </p>
                                                            <p style="color:white"><strong>contactar con nosotros</strong>, responderemos lo antes posible.
                                                            </p></center>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody></table>

                        </td>
                    </tr>
                    </tbody></table></td></tr>
    </table>
</div>
</body>

</html>
