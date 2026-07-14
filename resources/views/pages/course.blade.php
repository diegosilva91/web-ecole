@php
    $seo_title = $course->title . __(' | Cursos Online | Lifecole');
    if ($course->meta_description) {
        $seo_description = $course->meta_description;
    } else {
        $seo_description = __('Apúntate al curso ') . $course->title . __('. Aprende ') .  $course->category()->title . __(' con profesores cualificados, sin moverte de casa con los cúrsos de Lifecole.');
    }
@endphp

@extends('layouts.main')
@section('main_id') <v-app id="course"> @endsection

@prepend('styles')
    <style>
        @media (min-width: 1800px){
            .container{
                max-width: 1185px !important;
            }
        }

        .text-type-course{
        font-weight: 600;
        color: #29c0d3;
        margin-right: 10px;
        }

        .text-title-course {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
@endprepend

@section('og_tags_image') <meta property="og:image" content="@image($course->cover_image)"/>  @endsection
@section('og_tags')
    @parent
    <meta property="og:title" content="{{$course->title}}  | Cursos Online | Lifecole"/>
@endsection

@section('google_tag_manager')
    dataLayer.push({
        'ecommerce': {
            'currencyCode': 'EUR',
            'impressions': [
                {
                    'name': '{{$course->title}}',
                    'id': '{{$course->id}}',
    @isset($course->discount)
        'price': '@json(  $course->price_total- ($course->price_total * ( (int)$course->discount/100)  ) )',
    @else
        'price': '@json($course->price_total)',
    @endisset
                    'brand': '{{$course->type_course}}',
                    'category': '{{$course->category()->title}}'
                }
            ]
        }
    });
    function checkAvailability() {
        dataLayer.push({
            'event': 'viewAvailability',
            'ecommerce': {
                'currencyCode': 'EUR',
                'detail': {
                    'products': [{
                        'name': '{{$course->title}}',
                        'id': '{{$course->id}}',
    @isset($course->discount)
        'price': '@json( $course->price_total- ($course->price_total*((int)$course->discount/100)) )',
    @else
        'price': '@json($course->price_total)',
    @endisset
                        'brand': '{{$course->type_course}}',
                        'category': '{{$course->category()->title}}'
                    }]
                }
            }
        });
    }
    function Payment() {
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'currencyCode': 'EUR',
                'add': {
                    'products': [{
                        'name': '{{$course->title}}',
                        'id': '{{$course->id}}',
    @isset($course->discount)
        'price': '@json( ($course->price_total- ($course->price_total*((int)$course->discount/100))) ) ',
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
    }
@endsection

@php
    if(isset($course->type_course)){
        $trajectory=$course->type_course===\App\Course::TYPE_TRAJECTORY?1:0;
    }elseif(isset($course->is_subscription)){
        $trajectory=$course->is_subscription;
    }else{
        $trajectory=0;
    }
@endphp

@section('main_content')
<div>
    {{-- Ficha Produto Nueva --}}
    {{-- Desktop --}}
    <div class="d-none d-lg-block">
        <course-details-header
            :session='@json($course->session)'
            :user_id='@json(Auth::id())'
            :category='@json($course->specialization()->category())'
            :promotion='@json($promotions->first())'
            :last_promotion='@json($promotions->last())'
            :course='@json($course)'
            description_type_course='@json($course->descriptionTypeCourse())'
            course_url='@json(url()->current())'
            :likes='@json($course->likes)'
            :url='@json($url)'
            :trajectory='@json($trajectory)'
            :has-opinions='@json($course->getRawTotalReviews() > 0)'
        ></course-details-header>
    </div>
    {{--end--}}

    {{-- Mobile --}}
    <div class="d-block d-lg-none">
        <x-course-details-header-mob :course="$course" :trajectory="$trajectory"/>
        <x-course-details-card-mob :course="$course" :trajectory="$trajectory??false" :promotion="$promotions->first()" />
        <course-footer></course-footer>
        <!-- <x-banner-buy-mob :course="$course" :trajectory="$trajectory"/> -->
    </div>
    {{--end--}}

    <!-- PLANS -->
    <course-plans-mini-container
        v-if='@json($trajectory)'
        class="d-lg-none d-xl-none"
    ></course-plans-mini-container>

    <!-- DESCRIPTION -->
    <div id="description">
        <x-course-details-description :course="$course" :trajectory="$trajectory" :baseUrlAssets="$url"/>
    </div>

    <!-- INFO -->
    <div id="info">
        <course-details-why
            is-details='true'
            title="¿Por qué debería hacer este curso?"
            :course='@json($course)'
            :trajectory='@json($trajectory)'
        ></course-details-why>

        <x-course-details-video :course="$course"/>
    </div>

    <!-- PROMOTIONS -->
    <div id="promotions">
        <div class="d-lg-block">
            <course-details-promotions
                :next_months='@json($next_months)'
                :course='@json($course)'
                :course_url='@json(url()->current())'
                :trajectory='@json($trajectory)'
            ></course-details-promotions>
        </div>
    </div>

    <!-- REQUIREMENTS -->
    <div id="requirements">
        <x-course-details-requirements :url="$url" :requirements="$course->requirement()"/>
    </div>

    <!-- TEACHERS -->
    @if(count($teachers))
    <div id="teachers" class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8">
                <h2 class="h2-txt mb-8 mt-lg-40">Profesores</h2>
                <p class="p2-txt text-dark mb-7">Aquí podrás ver más en detalle quienes son los profesores que imparten este curso.</p>
                <teachers-expansion-panels
                    enlarge-avatar-on-open
                    :max-items='3'
                    no-lateral-space
                    :teachers='@json($teachers)'
                    :url-base='@json($url)'
                ></teachers-expansion-panels>
                @if(count($teachers) > 3)
                <teachers-dialog :teachers='@json($teachers)' :url-base='@json($url)'></teachers-dialog>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- OPINIONS -->
    @if($course->getRawTotalReviews() > 0)
    <div id="opinions" class="container">
        <div class="row">
            <course-opinions :course_id='@json($course->id)'></course-opinions>
        </div>
    </div>
    @endif

    <!-- FAQS -->
    <div id="faq">
        <course-details-why
            class="mb-160"
            :seo-text='true'
            is-details='false'
            title="FAQ"
            :course='@json($course)'
            :trajectory='@json($trajectory)'
        ></course-details-why>
    </div>

</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/course.js') }}"></script>
@endpush
