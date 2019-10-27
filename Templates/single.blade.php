@extends('Layout.theme')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('Snippets.content-single-'.get_post_type())
  @endwhile
@endsection
