<div class="clock-styling bg-dark" style="position: absolute; bottom: 0; left: 0; margin-left: 3em;">

    <div class="clock-styling-child" style="width:75px; text-align:start">
        <i class="far fa-clock"></i>
        <span id class="text-right clock" style="font-size:12px">00:00:00</span>
    </div>

    @if (Auth::user())

        |

        <div style="margin:auto 5px">
            <a href="{{ url('info/which-waystone') }}"><i class="fa fa-user"></i></a>
            <a href="{{ url('info/which-waystone') }}"><i class="fa fa-comments"></i></a>
            <a href="{{ url('info/which-waystone') }}"><i class="fa fa-binoculars"></i></a>
        </div>
        |
        <div style="margin-left:5px">
            <a href="{{ url('info/which-waystone') }}"><i class="fa fa-credit-card"></i></a>

            @php
                $curCount = 0;
            @endphp
            @foreach (Auth::user()->getCurrencies(false) as $currency)
                @if ($curCount == 0)

                    {!! $currency->quantity !!}
                    @php
                        $curCount++;
                    @endphp
                @endif

            @endforeach
        </div>
    @endif


</div>

@yield('scripts')
@section('scripts')
<script>
    $(document).ready(function setTimerWidth() {
        console.log("we");
        @if (!Auth::user()) {
                $(".clock-styling-child").css("width", "70px");
            }
        @endif
    });

</script>
@endsection