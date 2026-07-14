@isset($course->cover_video)
<div class="container">
    <div class="row mt-20">
        <div class="col-12 col-md-12 col-lg-8">
            <iframe width="100%" height="345" src="{{$course->cover_video}}" style="border-radius: 7px;" frameborder="0"></iframe>
        </div>
    </div>
</div>
@endisset
