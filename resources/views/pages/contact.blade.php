@php
    $seo_title = __('Contacto | Cursos para niños de 3 a 18 años | Lifecole');
    $seo_description = __('✓ LIFECOLE CONTACTO ⇨ Cursos y extraescolares online con profesores cualificados ᐅ Refuerzo de Matemáticas; Programación y Robótica; Música, Idiomas y más');
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="contact" data-app> @endsection


@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('google_tag_manager')
    @isset($lead)
{{--dataLayer.push({ 'pageTitle': 'contact', 'event': '$lead' });--}}
    @endif
    @if(session('lead'))
{{--dataLayer.push({ 'pageTitle': 'contact', 'event': '{{session('lead')}}' });--}}
    @endif
    function Contact()
    {
        gtag('event', 'ContactForm');
{{--    dataLayer.push({ 'pageTitle': 'contact', 'event': 'contact' });--}}
    }
@endsection

@prepend('styles')
    <style type="text/css">
        @media (min-width: 1800px){
            .container{
                max-width: 1185px !important;
            }
        }

        .contact-inputs:focus{
            border-color: #29c0d3 !important;
        }

        option[value=""][disabled] {
            display: none;
        }

        select {
            background-image: url("/assets/images/icons/arrow_black.svg");
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 15px;
        }

        label>span {
            opacity: 0.7;
            font-size: 12px;
            font-weight: 300;
        }

        .bg-alert {
            height: auto;
            border-radius: 4px;
            background-color: rgba(41, 192, 211, 0.2);
            padding: 10px;
        }

        h6.info-alert-txt {
            font-size: 12px;
            line-height: 1.7;
        }

        h6.info-alert-txt>span {
            font-weight: 600;
        }

        .info-teacher-contact {
            font-family: 'Poppins';
            font-size: 16px;
            text-align: center;
            color: #343a40;
        }

        .btn-teacher-contact {
            width: 203px;
            height: 46px;
            font-family: 'Poppins';
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px 0 rgba(35, 158, 173, 0.5);
            background-color: #29c0d3;
        }

        .msg-error {
            font-family: 'Poppins';
            font-size: 12px;
            color: #ff5252;
            margin-top: 2px;
            padding-left: 8px;
        }

    </style>
@endprepend

@section('main_content')
    <section class=" contact_area pt-40 pb-60">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="contact_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="section_title">
                                    <h1 class="h2-txt-med text-center">{{$title}}</h1>
                                    <p class="h6-txt text-dark text-center">Si tienes cualquier pregunta o simplemente quieres saludarnos, la mejor manera de contactarnos <br class="d-none d-lg-block"/> es a través de nuestro formulario. Te responderemos con la mayor brevedad prosible. ¡Gracias!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            {{session('message')}}
                        </div>
                    @endif
                    @if( Request::fullUrl() === Request::fullUrlWithQuery(['subject'=>'1']))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Nuevos cursos estarán disponibles pronto. Si deseas más información envíamos una
                                solicitud de contacto.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($sender=="lifecole")
                        <form method="POST" action="/es/contacto">
                            @elseif($sender=="teacher")
                                <form method="POST" action="/es/contacto?contact_id={{$contact_id}}">
                                    @else
                                    @endif
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="name">Nombre</label>
                                                <input class="contact-inputs h7-txt-light text-dark" type="text" name="name"
                                                       value="{{ old('name') }}">
                                            </div> <!-- single form -->
                                            @error('name')
                                            <div class="msg-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="email">Correo</label>
                                                <input class="contact-inputs h7-txt-light text-dark" type="email" name="email"
                                                       value="{{ old('email') }}">
                                            </div> <!-- single form -->
                                            @error('email')
                                            <div class="msg-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="number">Teléfono</label>
                                                <input class="contact-inputs h7-txt-light text-dark" type="text" name="number"
                                                       value="{{ old('number') }}">
                                            </div> <!-- single form -->
                                            @error('number')
                                            <div class="msg-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-5">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="subject">Asunto</label>
                                                <select class="contact-inputs h7-txt-light text-dark" id="subject" type="text" name="subject"
                                                        value="{{ old('subject') }}">
                                                    <option class="h7-txt-light" value="" disabled selected>Seleccione el asunto</option>
                                                    <option
                                                        value="Solicitud de Sesión Online Informativa">
                                                        Solicitud de Sesión Online Informativa
                                                    </option>
                                                    <option
                                                        <?php if (Request::fullUrl() === Request::fullUrlWithQuery(['subject' => 'teacher'])) echo 'selected';?> value="Contactar con un profesor">
                                                        Contactar con el área de coordinación académica
                                                    </option>
                                                    <option id="teacher" <?php if (Request::fullUrl() === Request::fullUrlWithQuery(['subject' => 'lead-teacher'])) echo 'selected';?> value="Quiero ser profesor de lifecole">
                                                        Quiero ser profesor de lifecole
                                                    </option>
                                                    <option
                                                        value="Preguntas generales">
                                                        Preguntas generales
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- single form -->
                                            @error('subject')
                                            <div class="msg-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="subject">Categoría <span id="label_category">(Opcional)</span></label>
                                                <select class="contact-inputs h7-txt-light text-dark" id="category" type="text" name="category" oninput="setCustomValidity('')"
                                                        value="{{ old('category') }}">
                                                    <option class="h7-txt-light" value="" disabled selected>Seleccione categoría</option>
                                                    <option value="Educación, metodologías e idiomas">
                                                        Educación, metodologías e idiomas
                                                    </option>
                                                    <option value="Informática, programación y videojuegos">
                                                        Informática, programación y videojuegos
                                                    </option>
                                                    <option value="Robótica e ingeniería industrial">
                                                        Robótica e ingeniería industrial
                                                    </option>
                                                    <option value="Arte digital">
                                                        Arte digital
                                                    </option>
                                                    <option value="Producción audiovisual">
                                                        Producción audiovisual
                                                    </option>
                                                    <option value="Desarrollo de marca y estrategia digital">
                                                        Desarrollo de marca y estrategia digital
                                                    </option>
                                                </select>
                                            </div>
                                            <!-- single form -->
                                            <div id="msg_error_category" @if($errors->has('category')) @else class="d-none" @endif>
                                                @error('category')
                                                    <div class="msg-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    <div id="partial_contact">
                                        <div class="col-md-12">
                                            <div class="single_form">
                                                <label class="h7-txt text-dark" for="message">Mensaje</label>
                                                <textarea class="contact-inputs h7-txt-light text-dark" name="message" style="height: 178px;">{{ old('message') }}</textarea>
                                            </div> <!-- single form -->
                                            @error('message')
                                            <div class="msg-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 text-center text-sm-right h7-txt-light text-dark"><input  type="checkbox" name="" id="contact" required style="vertical-align: middle;" oninvalid="this.setCustomValidity('Debe aceptar la Política de Privacidad')" oninput="setCustomValidity('')"> He leído y acepto la <a class="blue-title h7-txt" href="/es/politica-de-privacidad">Política de Privacidad</a>.
                                        </div>
                                        <div class="col-12 text-center text-sm-right">
                                            <div class="single_form">
                                                <button class="btn-buy text-light" style="font-family: 'Poppins'; font-size: 16px; font-weight: 600;width:145px;height:46px;" onclick="Contact()">Enviar</button>
                                            </div> <!-- single form -->
                                        </div>
                                        <div class="bg-alert col-12 mt-30 d-flex">
                                            <img class="my-auto mr-10" src="/assets/images/icons/info.png" width="20px" height="20px" alt="">
                                            <div class="d-block">
                                                    <h6 class="info-alert-txt">Si tienes problemas con algún pago, escribe o llama al número: <span>Ventas:</span> +34 622 45 23 83.</h6>
                                                <h6 class="info-alert-txt">Si es con alguno de los programas en los que ya estás inscrito: <span>Coordinación académica:</span> +34 622 90 64 68.</h6>
                                            </div>
                                        </div>
                                        <p class="col-12 h8-txt-light mt-50 text-center">
                                            INFORMACIÓN PROTECCIÓN DE DATOS DE LIFECOLE, S.L. Finalidades:
                                            Facilitarle un medio para que pueda ponerse en contacto con nosotros y
                                            atender a sus consultas y/o peticiones, incluso por medios electrónicos.
                                            Legitimación: Consentimiento expreso del interesado. Destinatarios No se
                                            prevén cesiones de datos a terceros. Derechos: Puede retirar su
                                            consentimiento en cualquier momento, así como acceder, rectificar, suprimir
                                            sus datos y demás derechos en educacion@lifecole.com. Información Adicional:
                                            Puede ampliar la información en el enlace de Política de Privacidad.
                                        </p>
                                    </div>
                                    @if($sender=="lifecole")
                                </form>
                            @elseif($sender=="teacher")
                        </form>
                    @else
                    @endif
                </div>
                <div id="partial_teacher" class="d-none">
                    <p class="info-teacher-contact mt-50">Accede a nuestra página “Dar clases” para convertirte en un Lifecooler</p>
                    <div class="d-flex">
                        <a href="/es/dar-clases" class="mx-auto mt-25 mb-150"><button class="btn-teacher-contact">¡Quiero ser profesor!</button></a>
                    </div>
                </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/contact.js') }}"></script>
@endpush
