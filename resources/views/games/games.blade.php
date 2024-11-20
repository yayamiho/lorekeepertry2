@extends('layouts.app')


@section('title') Games @endsection


@section('content')
{!! breadcrumbs(['Games' => 'games']) !!}


<div class="site-page-content parsed-text">
    <!--currency on top-->
    @foreach (Auth::user()->getArcadeCurrency(false) as $currency)

        @if (Settings::get('arcade_currency') == $currency->id)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-6 text-right">
                        <strong>
                            <a href="{{ $currency->url }}">
                                {{ $currency->name }}
                                @if ($currency->abbreviation)
                                    ({{ $currency->abbreviation }})
                                @endif
                            </a>
                        </strong>
                    </div>
                    <div class="col-lg-10 col-md-9 col-6">
                        {{ $currency->quantity }} 
                        @if ($currency->has_icon)
                            {!! $currency->displayIcon !!}
                        @endif
                        /
                        {{ Settings::get('arcade_currency_limit') }} 
                        @if ($currency->has_icon)
                            {!! $currency->displayIcon !!}
                        @endif
                    </div>
                </div>
            </li>
        @endif
    @endforeach

    {!! $page->parsed_text !!}
</div>


@endsection