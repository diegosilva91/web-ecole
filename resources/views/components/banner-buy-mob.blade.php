<div class="card-buy-mob fixed-bottom">
    <div class="container">
        <div class="row mx-auto align-items-center">
            <div class="col-6 text-left">
                @isset($course->discount)
                    @if($course->discount==='0.00')
                        @if($trajectory)
                            <div class="os24sb text-dark">{{$course->price_total }}€ / mes
                            </div>
                        @else
                    <div class="os24sb text-dark">{{$course->price_per_hour }}€ / h
                    </div>
                    <div class="total-price">Total: {{number_format((int)$course->price_total- ((int)$course->discount*(int)$course->price_total)/100,0,'.','') }}
                        €</div>
                        @endif
                    @else
                        @if($trajectory)
                            <div class="os24sb text-dark">{{$course->price_total }}€ / mes
                            </div>
                        @else
                        <div
                            class="os24sb text-dark">{{$course->price_per_hour }}€ / h
                        </div>
                            <div class="course-price">{{(int)$course->discount}}% Dto.<span
                            class="dto">{{$course->price_total}}€</span></div>
                            <div class="total-price">Total: {{number_format((int)$course->price_total- ((int)$course->discount*(int)$course->price_total)/100,0,'.','') }}
                                €</div>
                        @endif
                    @endif
                @endisset
            </div>
            <div class="col-6 row mx-auto justify-content-center">
                {{--@auth--}}
                
                    <a @if($trajectory) href="/es/cursos-anuales/payment/{{$course->id}}" @else href="/es/payment/{{$course->id}}"  @endif
                        class="btn-buy v-btn v-size--default theme--light"
                        style="width: 155px !important;height: 46px !important;"
                        @if(config('app.env') == 'production')
                        onclick="Payment()"
                        @endif >
                        <img src="/assets/images/home_vector/carrito.svg" alt=""> <span class="btn-price text-capitalize ml-4">{{$trajectory?'Suscribirme':'Comprar'}}</span>
                    </a>
                {{--@else
                    <button id="{{$course->promotions()->oldest('start_at')->first()->id}}" data-toggle="modal"
                            data-target="#RegisterPayment" type="button"
                            class="btn-buy v-btn v-size--default theme--light"
                            style="width: 145px !important;height: 46px !important;"
                            @if(config('app.env') == 'production')
                            onclick="Payment()"
                        @endif >
                        <img class="v-icon--left" src="/assets/images/home_vector/carrito.svg" alt="">
                        <span class="btn-price ">Comprar</span>
                    </button>
                @endauth--}}
            </div>
        </div>
    </div>
</div>
