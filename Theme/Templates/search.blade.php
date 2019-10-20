@extends('Layout.theme')

@section('content')
  @include('Snippets.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while(have_posts()) @php the_post() @endphp
    @include('Snippets.content-search')
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection
