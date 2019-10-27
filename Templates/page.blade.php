@extends('Layout.theme')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('Snippets.page-header')
    @include('Snippets.content-page')
  @endwhile
@endsection
