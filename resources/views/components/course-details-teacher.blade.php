
<div id="teacher" class="container">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8">
            <h2 class="h2-txt mb-8 mt-lg-40">Profesores</h2>
            <p class="p2-txt text-dark">Aquí podrás ver más en detalle quienes son los profesores que imparten este curso.</p>
            <v-expansion-panels>

                @foreach($teachers as $teacher_sup)
                <v-expansion-panel>
                <v-expansion-panel-header id="teacherHeader">
                        <div class="header-teacher">
                            <img width="70em" height="70em" style="border-radius: 50%;max-width:none !important;" class="mx-auto" src="{{$url.$teacher_sup->avatar}}" alt="">
                        </div>
                        <div class="col my-auto ml-4 header-teacher">

                            <h3 class="p2-txt-sbold">{{$teacher_sup->name}}</h3>

                        </div>
                    <template v-slot:actions>
                        <v-icon color="#29c0d3">$expand</v-icon>
                    </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                        <div class="row">
                            <div class="col-4 col-md-3 col-xl-2">
                                <img width="100em" height="100em" style="border-radius: 50%;max-width:none !important;" class="mx-auto" src="{{$url.$teacher_sup->avatar}}" alt="">
                            </div>
                            <div class="col-6 col-md-9 col-xl-10 my-auto">
                                <h3 class="p2-txt-sbold">{{$teacher_sup->name}}</h3>
                                <h4 class="p2-txt text-secondary mb-3 w-75">{{$teacher_sup->teacher()->first()->title}}</h4>
                                <course-rating  :score='@json($teacher_sup->teacher()->first()->avg_reviews)' :valorations='@json($teacher_sup->teacher()->first()->total_reviews)'    hiddenReviews=false ></course-rating><!--  vue-component -->
                            </div>
                        </div>

                    <div class="row mx-auto">
                        <div class="col-12 col-md-12 col-lg-12 text-dark pl-0">
                            <p class="p2-txt text-justify">{{$teacher_sup->teacher()->first()->bio}}</p>
                        </div>
                        @isset($course->teachers->rating1,$course->teachers->rating2,$course->teachers->rating3,$course->teachers->rating4)
                            @if($course->teachers->rating1!=='0.00' && $course->teachers->rating2!=='0.00' && $course->teachers->rating3!=='0.00' && $course->teachers->rating4!=='0.00')
                                <hr class="w-100">
                            @endif
                        @endisset
                        <course-reviews :course='@json($teacher_sup->teachers)'></course-reviews> <!--  vue-component -->
                    </div>
                </v-expansion-panel-content>
                </v-expansion-panel>
                @endforeach
            </v-expansion-panels>

            @if($course->getCourseReviews()->count() !== 0 )
               <course-opinions class="mt-3" :course_id='@json($course->id)'></course-opinions>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        .v-expansion-panel-header.v-expansion-panel-header--active>div.header-teacher {
          display: none;
        }

        .v-expansion-panel-header.v-expansion-panel-header--active#teacherHeader{
            padding-bottom: 0 !important;
            min-height: 0px;
            margin-top: 24px;
        }
    </style>
@endpush
