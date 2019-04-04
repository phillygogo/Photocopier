@extends('layouts.app')

 @section('content')
    <div class="photo-title">
        Select an ablum:
    </div>
    <div class="links">
        @foreach($PhotoAlbums as $album)
            <a href="/facebook/decision/{{ $album['id'] }}/{{ $album['name'] }}">{{ $album['name'] }}</a> <br>
        @endforeach
    </div>
 @endsection

