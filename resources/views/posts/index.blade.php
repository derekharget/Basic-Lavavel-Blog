@extends('layouts.app')

@section('title', 'blog posts')
    
@section('content')

{{-- @each('posts.partials.post', $posts, 'post') --}}

    @forelse ($posts as $key => $post)
    @include('posts.partials.post')
    @empty
        
    No posts found
        
    @endforelse

@endsection