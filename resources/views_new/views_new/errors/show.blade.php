
    <p style="font-size: 14px; font-weight:bold; color: red;">@if(empty($exception))您请求的页面不存在@else{{$exception}}@endif</p>
    <div class="blank"></div>
    @if(isset($links1))
        {!! $links1 !!}
    @elseif(isset($links))
        {!! $links !!}
    @else
        <p><a href="{{route('index')}}">前往首页</a></p>
    @endif
