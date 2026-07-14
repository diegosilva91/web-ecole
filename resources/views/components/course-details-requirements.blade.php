<div id="requirements" class="container">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8 dark-gray">
            <h2 class="h2-txt mb-8 mt-lg-40">Requisitos</h2>
            @foreach($requirements as $requirement)
            <div class="row p2-txt ml-2">
                <div class="col-2 my-auto row"><img class="mx-auto" width="38px" height="38px" src="{{$url.$requirement->cover_icon}}" alt=""/></div>
                <div class="col-10 my-auto"> {{$requirement->title}}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
