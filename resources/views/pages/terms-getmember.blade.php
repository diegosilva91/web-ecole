@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
<div>
    <section class="team_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section_title mt-30 mb-30">
                        <h3 class="main_title mt-dk-100">TÉRMINOS Y CONDICIONES DEL PROGRAMA <br> "INVITA A TUS AMIG@S"</h3>

                        <h5 class="mt-5">Usuari@ nuev@ con cupón de invitación/descuento</h5>
                        <p class="mt-4 text-secondary">Al emplear un cupón de invitación, recibes el 20% de descuento en tu compra de un curso. Podrás escoger entre cualquiera de los cursos que se ofertan en Lifecole.</p>
                        <p class="mt-4 text-secondary">Para hacer uso de tu cupón descuento simplemente introdúcelo en la página de checkout justo antes de proceder al pago de tu compra.</p>
                        <h5 class="mt-5">Usuari@ que invita</h5>
                        <p class="mt-4 text-secondary">L@s usuari@s registrad@s en Lifecole pueden invitar a sus amig@s a formar parte de Lifecole y ganar un curso gratuito. Para ello, es necesario que 5 usuari@s nuev@s realicen una compra con el cupón de invitación del/la usuari@ que les invita.<br><br>Recibirás tu cupón descuento para compartir con tus amig@s al registrarte en Lifecole. Dichos cupones tienen una validez de 1 año desde la fecha de tu registro.<br><br>Lifecole se reserva el derecho a no dejar redimir o usar el cupón de invitación en casos en que haya alta probabilidad de fraude o abuso del cupón.</p>
                        <ul class="text-secondary" style="list-style-type: disc">
                            <li>Lifecole se reserva el derecho de cancelar los códigos de invitación y código de las usuari@s que invitan en cualquier momento si se determina que se está incurriendo en fraude o engaño para obtener el descuento.</li>
                            <li>Las cuentas implicadas en los usos no autorizados, serán bloqueadas por tiempo indefinido.</li>
                            <li>Lifecole no permitirá la aplicación de los códigos cuando se verifique que las cuentas invitadas no son reales o son de usuarios falsos que no constituyan una persona natural identificable con un documento de identidad emitido por la autoridad competente.</li>
                            <li>Las compras realizadas con uso fraudulento del programa, serán canceladas.</li>
                            <li>No será posible crear nuevas cuentas con datos iguales o similares a los relacionados en las cuentas implicadas en el uso fraudulento.</li>
                            <li>Lifecole limita el uso de invitaciones a un máximo de 5 invitaciones. Superado ese número, no se podrán utilizar los cupones.</li>
                            <li>Lifecole se reserva el derecho a modificar las condiciones, cancelar o suspender el presente programa en cualquier momento y de forma unilateral, así como a cambiar el valor del premio ofrecido, y a negar a un usuario la participación en el programa.</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush
