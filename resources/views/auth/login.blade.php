<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>

<body class="min-h-screen bg-gray-100">

<div class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden
                grid grid-cols-1 md:grid-cols-2">

        {{-- ================= IMAGE SECTION ================= --}}
        <div class="relative h-60 md:h-auto">
            <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
                 class="w-full h-full object-cover"
                 alt="Login Image">
        </div>

        {{-- ================= FORM SECTION ================= --}}
        <div class="flex flex-col justify-center p-8 md:p-12">

            <h1 class="text-3xl md:text-4xl font-bold mb-2">
                Hi Designer 👋
            </h1>
            <p class="text-gray-500 mb-8">Welcome back</p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required autofocus
                           class="w-full px-4 py-3 border rounded-xl
                                  focus:ring-2 focus:ring-red-400">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password"
                           name="password"
                           required
                           class="w-full px-4 py-3 border rounded-xl
                                  focus:ring-2 focus:ring-red-400">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                               class="mr-2 rounded text-red-500 focus:ring-red-400">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-red-500 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Login Button --}}
                <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600
                               text-white py-3 rounded-xl font-semibold transition">
                    LOG IN
                </button>
            </form>

            {{-- Social Media --}}
            <div class="mt-10 text-center">
                <p class="text-gray-400 text-sm mb-4">Or connect with</p>

                <div class="flex justify-center space-x-6 text-xl text-gray-500">
                    <a href="#" class="hover:text-blue-600">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="hover:text-sky-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="hover:text-pink-500">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="hover:text-blue-700">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
