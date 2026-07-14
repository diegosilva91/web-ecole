<div class="row bg-header-mob align-items-center">
    <div class="container text-light ml-3">
        <div class="h6-txt"><span class="text-type-course">{{$course->descriptionTypeCourse()}}</span> {{$course->specialization()->category()->title}}</div>
        <div class="h6-txt mb-4"><span class="text-title-course"> {{$course->title}}</span></div>
        {{-- <div class="h7-txt-light {{$trajectory?'d-none':''}}">Impartido por <span class="h7-txt-sbold">{{$course->count_teachers}}</span> @if($course->count_teachers>1)profesores @else profesor @endif</div> --}}
        <div class="mb-2">
            @auth
            <favorite-button :user_id='@json(Auth::id())'
                             is_selected='@json($course->user_login_id)'
                             :course_id='@json($course->id)'
                             :label='@json($course->likes)'
                             color="white"></favorite-button>
            @endauth
            <share-button course_url='@json(url()->current())' color="white"></share-button>
        </div>
    </div>
</div>
