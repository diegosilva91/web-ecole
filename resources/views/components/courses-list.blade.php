
<div>
    <div class="container mb-100">
        @if($origin === 'teachers')
            <div class="row">
                @foreach($courses as $course)
                    <course-card-new :title='@json($course->title)' :age-max='@json($course->student_ages_max)'
                                     :category='@json($course->specialization()->category()->title)'
                                     :img='"@image($course->cover_image)"'
                                     :imgMobile='"@image($course->cover_image_mobile??$course->cover_image)"'
                                     :age-min='@json($course->student_ages_min)'
                                     :url='@json($course->getLink())'
                                     :price='@json($course->price_total)' :id='@json($course->id)'
                                     :total='@json($course->total_reviews)'
                                     :intro='@json($course->intro)'
                                     :start-at='@json(\Carbon\Carbon::parse($course->start_at)->toJson())'
                                     :discount='@json($course->discount)'
                                     :sessions='@json($course->duration)'
                                     :price-hour='@json($course->price_per_hour)'
                                     :type_course='@json($course->type_course)'
                                     :subtype_course='@json($course->subtype_course)'
                                     :rating='@json($course->avg_reviews)'
                                     :valorations='@json($course->total_reviews)'>
                        </course-card-new>
                @endforeach
            </div>
            @empty($course)
                <div class="d-flex mt-100">
                    <img class="mx-auto" src="/assets/images/vectors/new-course.svg" alt="">
                </div>
            @endempty
        @else
            <div class="row">
                @foreach($courses as $course)
                    <course-card-new :title='@json($course->title)' :age-max='@json($course->student_ages_max)'
                                     :category='@json($course->specialization()->category()->title)'
                                     :img='"@image($course->cover_image)"'
                                     :imgMobile='"@image($course->cover_image_mobile??$course->cover_image)"'
                                     :age-min='@json($course->student_ages_min)'
                                     :url='@json($course->getLink())'
                                     :price='@json($course->price_total)' :id='@json($course->id)'
                                     :total='@json($course->total_reviews)'
                                     :intro='@json($course->intro)'
                                     :start-at='@json(\Carbon\Carbon::parse($course->start_at)->toJson())'
                                     :discount='@json($course->discount)'
                                     :sessions='@json($course->duration)'
                                     :price-hour='@json($course->price_per_hour)'
                                     :type_course='@json($course->type_course)'
                                     :subtype_course='@json($course->subtype_course)'
                                     :rating='@json($course->avg_reviews)'
                                     :valorations='@json($course->total_reviews)'>
                        </course-card-new>
                @endforeach
            </div>
            @empty($course)
                <div class="alert alert-warning alert-dismissible fade show mb-20 mt-dk-100" role="alert">
                    <strong>No tienes cursos favoritos.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <a class="mb-200" href="/es/cursos"><button class="btn-favorite">VER CURSOS</button></a>
            @endempty
        @endif
    </div>
</div>
