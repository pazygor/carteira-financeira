<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembre de mim') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            <div class="flex items-center gap-4">
                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">
                    {{ __('Cadastre-se') }}
                </a>

                <button type="submit" id="login-button"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition flex items-center justify-center min-w-[100px]">
                    <span id="login-button-text">{{ __('Entrar') }}</span>
                    <svg id="login-spinner" class="animate-spin h-5 w-5 ml-2 hidden" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                            fill="none" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>
                </button>
            </div>
        </div>
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            const button = document.getElementById('login-button');
            const text = document.getElementById('login-button-text');
            const spinner = document.getElementById('login-spinner');

            button.disabled = true;
            text.textContent = 'Entrando...';
            spinner.classList.remove('hidden');
        });
    </script>
</x-guest-layout>