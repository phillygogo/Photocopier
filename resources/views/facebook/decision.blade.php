@extends('layouts.app')

 @section('content')
    <div class="photo-title">
        Photocopy into which location?
    </div>
    <div class="links">
        @foreach ($decisions as $key => $value)
            <a id="{{$key}}" href="/facebook/savePhotos/{{$key}}">{{$value}}</a>
        @endforeach
        <a href="" style="color:#636b6f36;">One Drive</a>
        <a href="" style="color:#636b6f36;">Dropbox</a>
    </div>
 @endsection
 