<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') - Paintful Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 text-gray-700">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-gray-300 flex flex-col shadow-xl">
        <!-- Brand -->
        <div class="h-24 flex items-center px-6 border-b border-gray-700">
            <a href="{{ url('/admin') }}" class="text-white font-bold text-lg tracking-wide">
                🎨 Paintful Admin
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1">
            @php
                $navItem = 'flex items-center px-3 py-2 rounded-md text-sm font-medium transition';
                $active = 'bg-gray-700 text-white border-l-4 border-indigo-500';
                $inactive = 'hover:bg-gray-700 hover:text-white';
            @endphp

            <a href="{{ url('/admin') }}"
               class="{{ $navItem }} {{ Request::is('admin') ? $active : $inactive }}">
                Dashboard
            </a>

            <a href="{{ url('/admin/brands') }}"
               class="{{ $navItem }} {{ Request::is('admin/brands*') ? $active : $inactive }}">
                Brands
            </a>

            <a href="{{ url('/admin/categories') }}"
               class="{{ $navItem }} {{ Request::is('admin/categories*') ? $active : $inactive }}">
                Categories
            </a>

            <a href="{{ url('/admin/products') }}"
               class="{{ $navItem }} {{ Request::is('admin/products*') ? $active : $inactive }}">
                Products
            </a>

            <a href="{{ url('/admin/orders') }}"
               class="{{ $navItem }} {{ Request::is('admin/orders*') ? $active : $inactive }}">
                Orders
            </a>

            <a href="{{ url('/admin/users') }}"
               class="{{ $navItem }} {{ Request::is('admin/users*') ? $active : $inactive }}">
                Users
            </a>
        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md
                               text-red-400 hover:bg-red-500/10 hover:text-red-300 transition">
                    Logout
                </button>
            </form>

            <p class="mt-3 text-xs text-gray-500 text-center">
                © {{ date('Y') }} Paintful
            </p>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 ml-64 flex flex-col">

        <!-- Header -->
        <header class="h-24 bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        @yield('title')
                    </h1>

                    @hasSection('breadcrumb')
                        <nav class="text-sm text-gray-500 mt-1">
                            @yield('breadcrumb')
                        </nav>
                    @endif
                </div>

                <!-- Placeholder for user menu -->
                <div class="text-sm text-gray-500">
                    {{ auth()->user()->email ?? 'Admin' }}
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>
</div>

</body>
</html>
