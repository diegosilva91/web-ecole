@extends('layouts.main')

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('google_tag_manager')
        dataLayer.push({
            'event':'purchase',
            'ecommerce': {
                'purchase': {
                    'actionField': {
                            'id': '{{$promotionPurchasePayment->stripe_payment_intent_token}}',                         // Transaction ID. Required for purchases and refunds.
                            'revenue': '{{$promotionPurchasePayment->total_price}}',         // Total transaction value (incl. tax)
                            'tax': '0.00',
                        },
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
        })
@endsection

@section('main_content')
    <div>
        <div class="container mx-auto mt-dk-100">
            <div class="row justify-content-md-center">
                <div class="col col-md-6 mb-4 mt-5primary-color">
                    @if ($promotionPurchasePayment->payment_method === 'transfer' || $promotionPurchasePayment->payment_method === 'Sepa')
                        <p id="banktrasnfer-alert" role="alert" class="errors-container alert alert-warning mt-2">Recuerda que tu compra no estará finalizada hasta que recibamos el ingreso en nuestra cuenta bancaria</p>
                    @endif
                    @if($errors->all())
                        <div class="errors-container alert alert-warning">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li> {!! $error !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="primary-color">Pago realizado con éxito</span>
                    </h4>
                    <p>Recibirás un correo electrónico de confirmación en breves momentos. Gracias por confiar en
                        mi-empresa</p>

                    <checkout-course-info
                        :course='@json($course)'
                        :promo-data='@json($coupon)'
                        :promotion='@json($promotion)'
                    ></checkout-course-info>

                    <a class="mx-auto" href="{{ url('es/lf/mis_cursos/'.Auth::id())  }}">
                        <button class="btn-buy mt-20 mb-20 text-light" style="width: 140px !important;">Mis cursos</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/payment-success.js') }}"></script>
    @if(Request::path()!=='es' && env('APP_ENV')==='production')
        <script src="https://cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>
        <script>window.LogRocket && window.LogRocket.init('llql1u/diego');</script>
    @endif
@endpush
