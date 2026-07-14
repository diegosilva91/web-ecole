@prepend('styles')
    <style>
        .card-details-mobile{
            height: 320px !important;
        }

        .session-info {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #29c0d3 !important;
            text-decoration: underline !important;
            cursor: pointer;
        }
    </style>
@endprepend

<div class="container">
<div class="card-details-mobile p2-txt p-4">
        <div class="mb-4"><img class="mr-2" width="12px" height="16px" src="/assets/images/course/icons/group-2.svg" alt=""/>Edad: {{$course->student_ages_min}}-{{$course->student_ages_max}} años</div>
        <div class="mb-4 mt-4">
            <img class="mr-2" width="13px" height="16px" src="/assets/images/course/icons/user.svg" alt=""/>Tamaño grupo: {{$course->students_min}}-{{$course->students_max}}
            <course-details-tooltip />
        </div>
        <div class="mb-4"><img class="mr-1" width="16px" height="16px" src="/assets/images/course/icons/group-3.svg" alt=""/>
            Duración @if(!$trajectory)clase @endif: @if($trajectory) hasta {{Illuminate\Support\Str::ucfirst(\Carbon\Carbon::parse($promotion->end_at)->locale('es')->monthName)}}@else {{$course->sessionTime}} min @endif
        </div>
    @if($trajectory)
        {{--        <div class="mb-4 {{$trajectory?'':'d-none'}}"><img class="mr-2" width="18px" height="18px" src="/assets/images/course/icons/group-4.svg" alt=""/>Frecuencia: {{$course->duration}}</div>--}}
        <div class="mb-4"><img class="mr-2" width="16px" height="18px" src="/assets/images/course/icons/group-4.svg" alt=""/>Frecuencia: {{$course->session}} día/ semana ({{ $course->sessionTime }} mins)
        </div>
        @if(isset($course->prices_enrollment) && $course->prices_enrollment instanceof Countable && count($course->prices_enrollment)>0)
                {{--        <div class="mb-4 {{$trajectory?'':'d-none'}}"><img class="mr-2" width="18px" height="18px" src="/assets/images/course/icons/shape.svg" alt=""/>Matrícula: {{$course->duration}}</div>--}}
                <div class="mb-4"><img class="mr-2" width="14px" height="16px" src="/assets/images/course/icons/shape.svg" alt=""/>Matrícula: @isset($course->prices_enrollment->total_price){{$course->prices_enrollment->total_price}}@endisset
                </div>
        @endif
        {{--        <div class="mb-4 {{$trajectory?'':'d-none'}}"><img class="mr-2" width="18px" height="18px" src="/assets/images/course/icons/group-5.svg" alt=""/>Consta de {{$course->duration}} niveles</div>--}}
        <div class="mb-4"><img class="mr-2" width="16px" height="16px" src="/assets/images/course/icons/group-5.svg" alt=""/>Consta de {{ $course->total_level }} niveles</div>
    @else
        <div class="mb-4 {{$trajectory?'d-none':''}}"><img class="mr-2" width="14px" height="16px" src="/assets/images/course/icons/shape.svg" alt=""/>Sesiones: {{$course->duration}}</div>
        <div class="mb-4 {{$trajectory?'d-none':''}}"><img class="mr-2" width="16px" height="18px" src="/assets/images/course/icons/group-4.svg" alt=""/>
            Días:
            @isset($course->daily)
                Varios
            @endisset
        </div>
        {{--        <div class="{{$trajectory?'d-none':''}}"><img class="mr-2" width="18px" height="18px" src="/assets/images/course/icons/group-5.svg" alt=""/>Nivel: {{$course->level}}</div>--}}
        <div class="mb-4"><img class="mr-2" width="16px" height="16px" src="/assets/images/course/icons/group-5.svg" alt=""/>Nivel: {{$course->level}}</div>
    @endif

    <modal-session class="{{$trajectory===1?'':'d-none'}}"></modal-session>

</div>
</div>
