@if(count($ad)>0)
    @foreach($ad as $v)
        <a href="{{$v->ad_link}}" target='_blank'><img src="{{$v->ad_code}}" alt=""/></a>
    @endforeach
@endif