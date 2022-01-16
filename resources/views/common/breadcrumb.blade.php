<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{$name}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            @foreach ($breadcrumb as $item)
                @if ($item["url"] == null)
                <li class="breadcrumb-item active">{{$item["name"]}}</li>
                @else
                <li class="breadcrumb-item"><a href="{{$item["url"]}}">{{$item["name"]}}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</div>