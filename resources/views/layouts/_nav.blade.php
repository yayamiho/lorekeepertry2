<nav class="navbar navbar-expand-md navbar-dark bg-dark" id="headerNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('lorekeeper.settings.site_name', 'Lorekeeper') }}
        </a>

        @include('layouts._clock')


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->is_news_unread && config('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('news') }}"><strong>News</strong><i
                                class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('news') }}">News</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Auth::check() && Auth::user()->is_sales_unread && config('lorekeeper.extensions.navbar_news_notif'))
                        <a class="nav-link d-flex text-warning" href="{{ url('sales') }}"><strong>Sales</strong><i
                                class="fas fa-bell"></i></a>
                    @else
                        <a class="nav-link" href="{{ url('sales') }}">Sales</a>
                    @endif
                </li>
                @if (Auth::check())
                    <!-- ACCOUNT -->
                    <li class="nav-item dropdown">
                        <a id="inventoryDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Account
                        </a>

                        <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
                            <a class="dropdown-item" href="{{ url('inventory') }}">
                                Inventory
                            </a>
                            <a class="dropdown-item" href="{{ url('pets') }}">
                                Pets
                            </a>
                            <a class="dropdown-item" href="{{ url('bank') }}">
                                Bank
                            </a>
                            @if(Auth::check())
                                @if(Auth::user()->shops()->count() && Settings::get('user_shop_limit') == 1)
                                    <a class="dropdown-item" href="{{ url(Auth::user()->shops()->first()->editUrl) }}">
                                        My Shop
                                    </a>
                                @else
                                    <a class="dropdown-item" href="{{ url('user-shops') }}">
                                        My Shops
                                    </a>
                                @endif
                            @endif
                            <a class="dropdown-item" href="{{ url('trades/open') }}">
                                Trades
                            </a>
                            <a class="dropdown-item" href="{{ url('awardcase') }}">
                                {{ ucfirst(__('awards.awards')) }}
                            </a>
                            <a class="dropdown-item" href="{{ url('collection') }}">
                                Collections
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ url('characters') }}">
                                My Characters
                            </a>
                            <a class="dropdown-item" href="{{ url('characters/myos') }}">
                                My MYO Slots
                            </a>
                            <a class="dropdown-item" href="{{ url('designs') }}">
                                Design Approvals
                            </a>
                            <a class="dropdown-item" href="{{ url('characters/transfers/incoming') }}">
                                Character Transfers
                            </a>
                        </div>
                    </li>

                    <!-- PLAY -->
                    <li class="nav-item dropdown">
                        <a id="queueDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" v-pre>
                            Play
                        </a>
                        <div class="dropdown-menu" aria-labelledby="queueDropdown">
                            <a class="dropdown-item" href="{{ url('info/which-waystone') }}">
                                Which Waystone
                            </a>
                            <a class="dropdown-item" href="{{ url('gallery') }}">
                                Gallery
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('prompts/prompts') }}">
                                Prompts
                            </a>
                            <a class="dropdown-item" href="{{ url('shops') }}">
                                Shops
                            </a>
                            <a class="dropdown-item" href="{{ url('user-shops/shop-index') }}">
                                All User Shops
                            </a>
                            <a class="dropdown-item" href="{{ url(__('cultivation.cultivation')) }}">
                                Cultivation
                            </a>
                            <a class="dropdown-item" href="{{ url('crafting') }}">
                                Crafting
                            </a>
                            <a class="dropdown-item" href="{{ url('raffles') }}">
                                Raffles
                            </a>
                        </div>
                    </li>
                @endif

                <!-- INFO -->

                <li class="nav-item dropdown">
                    <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Info
                    </a>

                    <div class="dropdown-menu" aria-labelledby="browseDropdown">
                        <a class="dropdown-item" href="{{ url('users') }}">
                            User Index
                        </a>
                        <a class="dropdown-item" href="{{ url('sublist/NPC') }}">
                            NPCs
                        </a>
                        <a class="dropdown-item" href="{{ url('sublist/PRE') }}">
                            PRE Masterlist
                        </a>
                        <a class="dropdown-item" href="{{ url('sublist/MYO') }}">
                            MYO Masterlist
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('world') }}">
                            Encyclopedia
                        </a>
                        <a class="dropdown-item" href="{{ url('world') }}">
                            Guides
                        </a>
                        <a class="dropdown-item" href="{{ url('world/library?bookshelf_id=1') }}">
                            Lore
                        </a>
                    </div>
                </li>
                <!-- COMMUNITY -->
                <li class="nav-item dropdown">
                    <a id="loreDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        Community
                    </a>

                    <div class="dropdown-menu" aria-labelledby="loreDropdown">
                        <a class="dropdown-item" href="{{ url('info/rules') }}">
                            Rules
                        </a>
                        <a class="dropdown-item" href="{{ url('info/find-us') }}">
                            Find Us
                        </a>
                        <a class="dropdown-item" href="{{ url('info/feedback') }}">
                            Feedback
                        </a>
                        <a class="dropdown-item" href="{{ url('reports/bug-reports') }}">
                            Bug Reports
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->isStaff)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin') }}"><i class="fas fa-crown"></i></a>
                        </li>
                    @endif
                    @if (Auth::user()->notifications_unread)
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary btn-sm" href="{{ url('notifications') }}"><span
                                    class="fas fa-envelope"></span> {{ Auth::user()->notifications_unread }}</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a id="browseDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Submit
                        </a>

                        <div class="dropdown-menu" aria-labelledby="browseDropdown">
                            <a class="dropdown-item" href="{{ url('submissions/new') }}">
                                Submit Prompt
                            </a>
                            <a class="dropdown-item" href="{{ url('claims/new') }}">
                                Submit Claim
                            </a>
                            <a class="dropdown-item" href="{{ url('reports/new') }}">
                                Submit Report
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('submissions?type=draft') }}">
                                Submission Drafts
                            </a>
                            <a class="dropdown-item" href="{{ url('claims?type=draft') }}">
                                Claim Drafts
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('submissions') }}">
                                My Prompts
                            </a>
                            <a class="dropdown-item" href="{{ url('claims') }}">
                                My Claims
                            </a>
                            <a class="dropdown-item" href="{{ url('reports') }}">
                                My Reports
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->url }}" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ Auth::user()->url }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ url('notifications') }}">
                                Notifications
                            </a>
                            <a class="dropdown-item" href="{{ url('account/bookmarks') }}">
                                Bookmarks
                            </a>
                            <a class="dropdown-item" href="{{ url('account/settings') }}">
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                                                                                                                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
    @yield('scripts')
    @include('layouts._pagination_js')
    <script>// CLOCK
        function time() {
            setInterval(function () {
                var date = new Date(); // initial date, this acts kinda like a first carbon instance so we can preform functions on it
                var time = new Date(date.getTime() - (3 * (60 * 60 * 1000)));  // preform function on first date (basically get time in timestamp format, the 60*60*1000 is an offset of +1 hour. To do other timezones just convert it to the necessary amount of hours +- GMT-3
                var cycle = (time.getUTCHours()) >= 12 ? ' PM' : ' AM'; // this gets the hour in military time so if it's greater than 12 it's pm
                // substr is a function that'll knock of certain letters from a given input. 
                // Because ours is -2, if we have 001, it'll read as 01. If we have 042, it'll be 42
                // we want this because getUTCSeconds() for example gives a single integer value for values < 10 (ex 1 second shows as 1)
                // this doesn't look correct so we basically ''force'' it to be correct by adding and (sometimes) removed the extra 0
                // we do getUTC so that it doesn't change per person and is universal
                // you can see more here https://stackoverflow.com/a/39418437/11052835
                var display = ('0'+time.getUTCHours()).substr(-2)  + ":" + ('0' + time.getUTCMinutes()).substr(-2) + ":" + ('0' + time.getUTCSeconds()).substr(-2); // make it look pretty
                $(".clock").text(display); // set the div to new time
            }, 1000)
        } // times it out for 1 second so loop

        setInterval(time(), 1000); // loop
    </script>
</nav>