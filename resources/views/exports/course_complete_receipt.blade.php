<!DOCTYPE html>
<html>
<body>
<div>
    <img style="z-index: 0" src="@image($data['img'])">
    <p style="font-family: 'Poppins';z-index: 1;left: 730px;position: absolute;top: 449px;font-size: 40px;">{{$data['user']->name}}</p>
    <p style="font-family: 'Poppins';z-index: 1;left: 500px;position: absolute;top: 660px;font-size: 40px;">{{$data['course']->title}}</p>
    <p style="font-family: 'Poppins';z-index: 1;left: 1075px;position: absolute;top: 965px;font-size: 30px;">{{\Carbon\Carbon::parse($data['date'])->format('j F, Y')}}</p>
</div>
</body>
</html>
