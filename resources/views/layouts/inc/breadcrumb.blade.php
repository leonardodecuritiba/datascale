<ol class="breadcrumb ">
    @foreach($Page->breadcrumb as $item)
        @if($item['route'] != NULL)
            <li class="breadcrumb-item"><a href="{{$item['route']}}"><i class="fa fa-{{$item['icon']}}"></i> {{$item['text']}}</a></li>
        @else
            <li class="breadcrumb-item active"><i class="fa fa-{{$item['icon']}}"></i> {{$item['text']}}</li>
        @endif
    @endforeach
</ol>
