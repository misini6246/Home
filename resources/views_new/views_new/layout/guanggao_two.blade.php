@if(count($ad)>0)
    @foreach($ad as $v)
        <li>
            <a href="{{$v->ad_link}}" target='_blank'>
                <img src="{{$v->ad_code}}" alt=""/>
            </a>
        </li>
    @endforeach
@endif