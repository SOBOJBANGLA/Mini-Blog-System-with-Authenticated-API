<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 align-items-center">
            <div class="flex align-items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="'/'" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <a href="/categories" class="nav-link" id="categoriesNavLink" style="display:none;">Categories</a>
                    <a href="/my-articles" class="nav-link" id="myArticlesNavLink" style="display:none;">My Articles</a>
                    <a href="/public-articles" class="nav-link">Public Articles</a>
                </div>
            </div>
            <!-- Guest: Login/Register, User: Welcome/Logout -->
            <div class="d-flex align-items-center" id="guestNav">
                <a href="{{ route('api.login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                <a href="{{ route('api.register') }}" class="btn btn-outline-success btn-sm">Register</a>
            </div>
            <div class="d-flex align-items-center" id="apiUserNav" style="display:none;">
                <span id="apiUserName" class="me-3 fw-bold"></span>
                <button id="apiLogoutBtn" class="btn btn-danger btn-sm">Logout</button>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="'/'" :active="request()->is('/')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>

<script>
let navToken = localStorage.getItem('api_token');
if(navToken) {
    fetch('/api/auth/me', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${navToken}`,
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.user && data.user.name) {
            document.getElementById('apiUserName').textContent = 'Welcome, ' + data.user.name;
            document.getElementById('apiUserNav').style.display = 'flex';
            document.getElementById('guestNav').style.display = 'none';
            document.getElementById('categoriesNavLink').style.display = 'inline';
            document.getElementById('myArticlesNavLink').style.display = 'inline';
        }
    })
    .catch(err => { document.getElementById('guestNav').style.display = 'flex'; });
} else {
    document.getElementById('guestNav').style.display = 'flex';
    document.getElementById('categoriesNavLink').style.display = 'none';
    document.getElementById('myArticlesNavLink').style.display = 'none';
}
document.getElementById('apiLogoutBtn')?.addEventListener('click', async function(e) {
    e.preventDefault();
    try {
        await fetch('/api/auth/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${navToken}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    } catch (error) {}
    localStorage.removeItem('api_token');
    window.location.href = '/';
});
</script>


