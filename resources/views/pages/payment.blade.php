@extends('layouts.main')

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_id') <v-app id="payment"> @endsection

@prepend('styles')
    <style type="text/css">
        .v-input .v-label {
            margin-bottom: 0px;
            margin-left: 30px;
            color: #343a40 !important;
        }

        .v-input input{
            max-height: 38px !important;
        }

        #card-element {
            height: auto !important;
            border: none !important;
            padding: 0px !important;
        }

        label{
            font-family: 'Poppins' !important;
        }

        .input-card {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            min-height: 38px;
            max-height: 41.2px;
            padding: 10px;
            flex: 1;
            cursor: text;
        }
        #card-element-number{
            outline: none;
            border:0;
        }

        .tooltip-cvc .tooltiptext {
            visibility: hidden;
            width: 180px;
            background-color: #555;
            color: #fff;
            font-family: 'Poppins';
            font-size: 14px;
            text-align: center;
            border-radius: 6px;
            padding: 10px 5px;
            position: absolute;
            z-index: 1;
            bottom: 70%;
            left: 45%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip-cvc .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
        }

        .tooltip-cvc:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
        }

        @empty($promotion)
        button:disabled{
            background-color: rgb(229, 229, 229) !important;
            box-shadow: none !important;
            cursor: not-allowed;
        }
        @endempty
    </style>
@endprepend

@section('main_content')
<div>

    <div class="container">
        @empty($promotion)
            <div class="d-block d-sm-none">
                <a href="#promoInpt">
                    <v-alert dense type="info">
                        <template v-slot:prepend>
                            <span class="v-icon notranslate v-alert__icon">@php echo Mdi::mdi('information-outline'); @endphp</span>
                        </template>
                        <span class="text-body-2">Recuerda que debes seleccionar primero la fecha del curso.</span>
                    </v-alert>
                </a>
            </div>
        @endisset
        <div class="row mx-auto justify-content-center">
            <div class="row py-5 mt-dk-80 mb-dk-80 px-3 pt-5 pb-10">

                <checkout-info
                    :course='@json($course)'
                    :promotion='@json($promotion)'
                    coupon=@json($coupon)
                ></checkout-info>

                <div class="col-12 col-lg-8 order-lg-1">
                    <h4 class="mb-3 text-muted">Información de compra</h4>
                    <div class="needs-validation validation"
                         data-cc-on-file="false"
                         data-stripe-publishable-key="{{env('STRIPE_KEY')}}"
                         id="payment-form">
                        {{ csrf_field() }}
                        @isset($promotion)
                            <input type="hidden" name="promotion_id" value="{{$promotion->id}}" id="promotion_id">
                        @endisset
                        <input type="hidden" name="course_id" value="{{$course->id}}" id="course_id">
                        <coupon-user :course='@json($course)'></coupon-user>

                        <checkout-promotion id="promoInpt" @isset($promotion):promotion='@json($promotion)' @endisset :course='@json($course)' :promotions='@json($promotions)'></checkout-promotion>

                        @empty($promotion)

                            <v-alert dense type="info">
                                <template v-slot:prepend>
                                    <span class="v-icon notranslate v-alert__icon">
                                        @php echo Mdi::mdi('information-outline', 'v-icon__svg'); @endphp
                                    </span>
                                </template>
                                <span class="text-body-2">Recuerda que debes seleccionar primero la fecha del curso.</span>
                            </v-alert>

                        @endisset

                        <div class="mb-4">
                            <label for="name">Nombre completo </label>
                            <input @empty($promotion) disabled @endempty type="text" class="form-control @error('name') is-invalid @enderror"
                                    @auth value="{{ Auth::user()->name}}" @else value="{{ old('name') }}" @endauth
                                    name="name" id="namePayment" placeholder="Nombre completo del padre, madre o tutor" required @auth readonly @endauth>
                            @error('name')
                            <div class="invalid-feedback" id="namePaymentError">
                                {{ $message }} Introduce tu nombre completo
                            </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email">Email <span class="text-muted">(Recibirás confirmación)</span></label>
                            <input @empty($promotion) disabled @endempty type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ Auth::user()->email ??  old('email')}}" id="emailPayment" required @auth readonly @endauth>
                            @error('email')
                            <div class="invalid-feedback" id="">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        @guest
                        <div class="mb-3">
                            <label for="password">Crear contraseña <span class="text-muted">(Necesario para el registro)</span> </label>
                            <input @empty($promotion) disabled @endempty type="password" name="password" class="form-control @error('password') is-invalid @enderror"  value="{{ Auth::user()->password ??  old('password')}}" id="passwordPayment" required @auth readonly @endauth>
                            @error('password')
                            <div class="invalid-feedback" id="passwordError">
                                La contraseña no es válida
                            </div>
                            @enderror
                        </div>
                        @endguest
                        <div class="mb-4">
                            <label for="phone">Teléfono <span class="text-muted"></span></label>
                            <input type="phone"  @empty($promotion) disabled @endempty name="phone" class="form-control @error('email') is-invalid @enderror" value="{{ Auth::user()->phone ??  old('phone')}}" id="phonePayment" required @auth @if(isset(Auth::user()->phone) || empty($promotion ))  readonly  @endif  @endauth>
                            @error('phone')
                            <div class="invalid-feedback" id="phoneError">
                                {{$message}}
                            </div>
                            @enderror
                        </div>

                        @auth
                            <input @empty($promotion) disabled @endempty type="hidden" name="password" class="form-control @error('password') is-invalid @enderror"  value="{{ Auth::user()->password ??  old('password')}}" id="passwordPayment" required @auth readonly @endauth>

                            <v-radio-group
                                id="sons_group"
                                mandatory
                                hide-details
                            >
                                @isset($user->UserAssistant)
                                    @if($user->UserAssistant->isNotEmpty())
                                        <div class="h6-txt mb-5 text-dark">Selecciona al hij@ que deseas inscribir</div>
                                        <div class="row">
                                            <div class="col-3 col-md-1 col-sm-2 mt-4">
                                                <br>
                                                @foreach($user->UserAssistant as $key=>$assistant)
                                                    <v-radio
                                                        class="radio_son"
                                                        name="check_assistant[{{$assistant->id }}]"
                                                        id="check_assistant[{{$assistant->id }}]"
                                                        value="{{$assistant->id }}"
                                                        @empty($promotion)disabled="disabled"@endempty
                                                    ></v-radio>
                                                    <br><br><br>
                                                @endforeach
                                            </div>
                                            <div class="col-6 col-md-6 col-sm-6">
                                                @foreach($user->UserAssistant as $assistantName)
                                                    <label class="h6-txt mb-3 text-dark">Nombre</label>
                                                    <input type="text" class="form-control mb-7"
                                                           value="{{$assistantName->name }}"
                                                           placeholder="Nombre de tu hij@" required disabled>
                                                @endforeach
                                            </div>
                                            <div class="col-3 col-md-4 col-sm-4">
                                                @foreach($user->UserAssistant as $assistantAge)
                                                    <label class="h6-txt mb-3 text-dark">Edad</label>
                                                    <input type="text" class="form-control mb-7"
                                                           value="{{$assistantAge->age }}"
                                                           placeholder="Edad de tu hij@" required disabled>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <v-radio
                                                    label="¿Deseas inscribir a algún hij@ más?"
                                                    value="new"
                                                    class="h6-txt radio_son"
                                                    name="add_son"
                                                    id="add_son"
                                                    @empty($promotion)disabled="disabled"@endempty
                                                ></v-radio>
                                            </div>
                                        </div>
                                @endif
                            @endempty
                            </v-radio-group>

                            <div id="user-assistant" class="row assistant" @if($user->UserAssistant->isNotEmpty())style="display:none;"@endif>
                                <div class="col-md-6 mb-3">
                                    <label class="h6-txt" for="assistant_name[0]">Nombre</label>
                                    <input @empty($promotion) disabled @endempty name="assistant_name[0]" id="assistant_name_0" type="text"
                                           class="form-control @error('assistant_name[0]') is-invalid @enderror"
                                           value="{{ old('assistant_name[0]') }}"
                                           @if($user->UserAssistant->isEmpty())
                                           required
                                           @endif
                                           placeholder="Nombre de tu hij@">
                                    @error('assistant_name[0]')
                                    <div class="invalid-feedback">
                                        Introduce el nombre de tu hij@
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="h6-txt" for="assistant_age[0]">Edad</label>
                                    <input @empty($promotion) disabled @endempty name="assistant_age[0]" id="assistant_age_0" type="number"
                                           class="form-control @error('assistant_age[0]') is-invalid @enderror"
                                           value="{{ old('assistant_age[0]') }}" placeholder="Introduce la edad de tu hij@"
                                           id="assistant_age_0"
                                           @if($user->UserAssistant->isEmpty())
                                           required
                                           @endif>
                                    @error('assistant_age[0]')
                                    <div class="invalid-feedback">
                                        Introduce la edad de tu hij@
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @else
                        <div id="user-assistant" class="row assistant">
                            <div class="col-md-6 mb-3">
                                <label class="h6-txt" for="assistant_name[0]">Nombre</label>
                                <input @empty($promotion) disabled @endempty name="assistant_name[0]" id="assistant_name_0" type="text"
                                       class="form-control @error('assistant_name[0]') is-invalid @enderror"
                                       value="{{ old('assistant_name[0]') }}"
                                       required
                                       placeholder="Nombre de tu hij@">
                                @error('assistant_name[0]')
                                <div class="invalid-feedback">
                                    Introduce el nombre de tu hij@
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="h6-txt" for="assistant_age[0]">Edad</label>
                                <input @empty($promotion) disabled @endempty type="number" name="assistant_age[0]" id="assistant_age_0"
                                       class="form-control @error('assistant_age[0]') is-invalid @enderror"
                                       value="{{ old('assistant_age[0]') }}" placeholder="Introduce la edad de tu hij@"
                                       required>
                                @error('assistant_age[0]')
                                <div class="invalid-feedback">
                                    Introduce la edad de tu hij@
                                </div>
                                @enderror
                            </div>
                        </div>
                        @endauth
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-8 pb-0 pb-sm-3">
                                <h4 class="pt-2 mb-sm-2 text-muted">Pagar con</h4>
                            </div>
                            <div class="col-12 col-sm d-flex align-items-center">
                                <img  src="/assets/images/logo/pagos.png" alt="" width="230px" class="ml-sm-auto">
                            </div>
                        </div>
                        <payment-select @empty($promotion) :disabled='true' @endempty></payment-select>
                        <div id="card-element"><!--Stripe.js injects the Card Element-->
                            <div class="d-lg-flex">
                                <div class="col-12 col-md-6 mr-2 pl-0 pb-0">
                                    <label class="h6-txt">Número de tarjeta</label>
                                    <div class="group-card-input-number">
                                        <div id="card-element-number" class="input-card"></div>
                                        <span class="brand"><i class="pf pf-credit-card" id="brand-icon"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mr-1 pl-0">
                                    <label class="h6-txt">Fecha de expiración</label>
                                    <div id="card-element-expiry" class="input-card"></div>
                                </div>
                                <div class="col-12 col-md-2 pl-0 tooltip-cvc">
                                    <label class="h6-txt d-flex">CVC<span class="d-block d-lg-none">*</span> <span class="tooltiptext">El CVC es el número de tres dígitos situado en la parte trasera de la tarjeta.</span></label>
                                    <div id="card-element-cvc" class="input-card"><span class="tooltiptext">El CVC es el número de tres dígitos situado en la parte trasera de la tarjeta.</span></div>
                                </div>
                            </div>
                            <div class="d-block d-lg-none">
                                <p class="h8-txt-light">*El CVC es el número de tres dígitos situado en la parte trasera de la tarjeta.</p>
                            </div>
                        </div>
                        <div id="sepa-element" class="d-none">
                            <label for="iban-element">
                                IBAN
                            </label>
                            <div id="iban-element" class="input-card">
                            </div>
                            <p class="col-12 h8-txt-light mb-0 mt-3 pl-0">
                                Al proporcionar sus datos de pago y confirmar este pago, usted autoriza a Mi-empresa S.L. y Stripe, nuestro proveedor de servicios de pago y/o a PPRO, su proveedor de servicios local, a enviar instrucciones a su banco para realizar un débito en su cuenta y (B) a su banco a realizar un cargo en su cuenta de conformidad con dichas instrucciones. Como parte de sus derechos, usted tiene derecho a un reembolso de su banco conforme a los términos y condiciones del contrato con su banco. El reembolso debe reclamarse en un plazo de 8 semanas a partir de la fecha en la que se haya efectuado el cargo en su cuenta. Sus derechos se explican en un extracto que puede obtener en su banco. Usted acepta recibir notificaciones de futuros débitos hasta 2 días antes de que se produzcan.
                            </p>
                        </div>
                        <div id="payPal" class="d-none">
                            <div class="p3-txt mb-2">Inicia sesión para usar PayPal</div>
                            <div id="smart-button-container">
                            <div style="text-align: center; width:300px;">
                              <div id="paypal-button-container"></div>
                            </div>
                          </div>
                        </div>
                        <div id="transfer-bank" class="d-none">Para completar tu compra, debes realizar un ingreso de
                            <b id="price-transfer">@isset($course->discount)
                                    @if($course->discount==='0.00')
                                        {{$course->price_total- ($course->price_total*((int)$course->discount/100))}}
                                    @else
                                        {{$course->price_total}}
                                    @endif
                                @endif€</b>
                            en la siguiente cuenta:<br> <h5>IBAN ES72 0081 7011 1600 0355 7968</h5><br> Indicando en el concepto:@isset($promotion) <b>{{$promotion->id}}</b> @endisset - tu email | <span class="text-muted">Ejemplo:@isset($promotion) {{$promotion->id}}@endisset - tunombre@tuemail.com</span><br> Para finalizar tu compra, haz click en confirmar.
                        </div>
                        <p id="card-error" role="alert" class="errors-container alert alert-danger mt-2" style="display:none;"></p>
                        <div class="align-items-center">
                            <div class="col-12 col-md-12 col-lg custom-control custom-checkbox mt-5">
                                <input @empty($promotion) disabled @endempty type="checkbox" class="custom-control-input mr-2" id="policy" required>
                                <label class="custom-control-label p3-txt d-inline" for="policy">
                                He leído y acepto los <a href="/es/terminos-y-condiciones" style="color: #29c0d3;font-weight: 400;">Términos y Condiciones</a>, así como la <a href="/es/politica-de-privacidad" style="color: #29c0d3;font-weight: 400;">Política de Privacidad</a>.
                                </label>
                            </div>
                        <p class="col-12 h8-txt-light mb-0">
                            INFORMACIÓN PROTECCIÓN DE DATOS DE MI-EMPRESA, S.L. Finalidades: Para la
                            correcta reserva y compra de los cursos en la Plataforma. Legitimación:
                            Consentimiento expreso y la ejecución de la relación contractual e interés
                            legítimo. Destinatarios: No se prevén cesiones de datos a terceros. Derechos:
                            Puede retirar su consentimiento en cualquier momento, así como acceder,
                            rectificar, suprimir sus datos y demás derechos en educacion@mi-empresa.com.
                            Información Adicional: Puede ampliar la información en el enlace de Política de
                            Privacidad.
                        </p>

                        <p class="col-12 h8-txt-light">
                            “Para su seguridad, hemos confiado en el sistema de pago mediante tarjeta de crédito o débito a una pasarela de pago segura. Los datos bancarios introducidos son encriptados y transmitidos de forma segura a los servidores de la entidad bancaria y posteriormente, son verificados con el banco emisor para evitar posibles fraudes y abusos.”
                        </p>
                        </div>
                        <div class="row">
                            <button @empty($promotion) disabled @endempty id="submit" type="button" class="col-12 col-md-12 col-lg-4 btn-buy v-btn v-size--default theme--light row ml-sm-auto mr-sm-1 ml-lg-auto mt-lg-3 mr-lg-3 mt-5 ml-6" style="width: 280px !important; height: 46px !important;">
                                <v-progress-circular id="submitProgress" style="display: none" color="#fff" width="3" indeterminate></v-progress-circular>
                                <span id="submitContent">
                                    <img src="/assets/images/home_vector/carrito.svg" alt=""> <span id="btnText" class="btn-price ml-4">Confirmar</span>
                                </span>
                            </button>
                            <button @empty($promotion) disabled @endempty id="submit-transfer" type="button" class="col-12 col-md-12 col-lg-4 btn-buy v-btn v-size--default theme--light row ml-sm-auto mr-sm-1 ml-lg-auto mt-lg-3 mr-lg-3 d-none mt-5 ml-6" style="width: 280px !important; height: 46px !important;"><img src="/assets/images/home_vector/carrito.svg" alt=""> <span id="btnText" class="btn-price ml-4">Confirmar</span></button>
                        </div>
                    </div>
                    <div class="errors-container alert mt-30" id="errors"></div>
                </div>
            </div>
        </div>
        @php
            if(empty($modalToHome)){
                $modalToHome=false;
            }
        @endphp
        <payment-modal :active='@json($modalToHome)'></payment-modal>
    </div>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/payment.js') }}" defer></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&currency=EUR" data-sdk-integration-source="button-factory" data-csp-nonce="xyz-123"></script>
    @if(Request::path()!=='es' && env('APP_ENV')==='production')
        <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
        <script>window.LogRocket && window.LogRocket.init('llql1u/diego');</script>
    @endif
@endpush

@section('google_tag_manager')

            dataLayer.push({
                'event': 'checkout',
                'currencyCode': 'EUR',
                'ecommerce': {
                    'checkout': {
                        'products': [{
                            'name': '{{$course->title}}',
                            'id': '{{$course->id}}',
        @isset($course->discount)
            'price': '@json($course->price_total- ($course->price_total*((int)$course->discount/100)))',
            @else
            'price': '@json($course->price_total)',
        @endisset
                            'brand': '{{$course->type_course}}',
                            'category': '{{$course->category()->title}}',
                            'quantity': 1
                        }]
                    }
                }
            });
@endsection
