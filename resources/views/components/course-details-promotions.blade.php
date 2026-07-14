<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-7">
            <h2 class="h2-txt mb-8 mt-lg-40">Disponibilidad</h2>
            <div class="container">
                @foreach($promotions as $promotion)
                <div class="row card-promotion p3-txt mb-4">
                    <div class="col-2 p3-txt my-auto">
                        <div>Inicio<br><span class="p3-txt-sbold">{{ \Carbon\Carbon::parse($promotion->start_at)->format('d-m-Y') }}</span></div>

                    </div>
                    <div class="col-2 p3-txt my-auto">
                        <div>Fin<br><span class="p3-txt-sbold">{{ \Carbon\Carbon::parse($promotion->end_at)->format('d-m-Y') }}</span></div>
                    </div>
                    <div class="col-2 p3-txt my-auto">
                        <div>Día<br>
                            <span class="p3-txt-sbold">
                                  @isset($promotion->daily)
                                    @if(json_decode($promotion->daily,true))
                                    @foreach ((is_array($promotion->daily) ? $promotion->daily : \GuzzleHttp\json_decode($promotion->daily, true)) as $dailies)
                                        {{ $loop->first ? '' : '/' }}
                                            @switch($dailies)
                                                @case("0")Lunes
                                                @break
                                                @case("1")Martes
                                                @break
                                                @case("2")Miercoles
                                                @break
                                                @case("3")Jueves
                                                @break
                                                @case("4")Viernes
                                                @break
                                                @case("5")Sábado
                                                @break
                                                @default Lunes
                                            @endswitch
                                    @endforeach
                                @else
                                    Lunes
                                @endif
                                @endisset
                            </span>
                        </div>
                    </div>
                    <div class="col-2 p3-txt my-auto">
                        <div>Hora<br><span class="p3-txt-sbold">{{ \Carbon\Carbon::parse($promotion->start_at)->format('H:i') }}</span></div>
                    </div>
                    <div class="col-2 p3-txt my-auto pl-0">
                        <div class="purple-title">Solo quedan<br><span class="p3-txt-sbold">{{$course->students_max-$count->where('id',$promotion->id)->count()}} espacios</span></div>
                    </div>
                    <div class="col-2 p3-txt my-auto pl-0">
                        <div>
                            {{--@auth--}}
                            <a href="/es/payment/{{$promotion->id}}" class="btn-booking-mob v-btn v-size--default theme--light"
                                @if(config('app.env') == 'production')
                                    onclick="Payment()"
                                @endif >
                                <span class="btn-price blue-title text-capitalize">Reservar</span>
                            </a>
                        {{--@else
                            <button id="{{$promotion->id}}" data-toggle="modal" data-target="#RegisterPayment"
                        type="button" class="btn-booking v-btn v-size--default theme--light"
                        @if(config('app.env') == 'production')
                            onclick="Payment()"
                        @endif >
                        <span class="btn-price blue-title text-capitalize">Reservar</span>
                        </button>
                        @endauth--}}
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="row p3-txt">¿No ves un horario que te funcione?</div>
                <a class="row p3-txt" href="/es/contacto"><strong class="blue-title">¡Solicita otro nuevo!</strong></a>
            </div>
        </div>
    </div>
</div>
