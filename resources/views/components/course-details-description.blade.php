@prepend('styles')
    <style type="text/css">
        .pdf-info {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #29c0d3 !important;
            text-decoration: underline !important;
        }
    </style>
@endprepend

<div class="container">
    <div class="row mt-50">
        <div class="col-12 col-md-12 col-lg-8">
            <h2 class="h2-txt mb-8 mt-lg-16">Descripción</h2>
            <p class="p2-txt">{!! $course->intro !!}</p>
            @isset($course->is_subscription)
                @if($course->is_subscription===1)
                    <a href="{{$baseUrlAssets.$course->content_detail}}"
                    class="pdf-info mt-2 {{$trajectory?'':'d-none'}}" target="_b">Descargar detalle del curso en PDF <img
                    src="/assets/images/icons/pdf.svg" alt="pdf" class="ml-2"></a>
                @endif
            @endisset
        </div>
    </div>
</div>

