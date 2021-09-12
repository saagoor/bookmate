<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/"
                class="block mb-3">
                <x-application-logo class="w-auto h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4"
            :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4"
            :errors="$errors" />

        <form method="POST"
            action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email"
                    :value="__('Email')" />

                <x-input id="email"
                    placeholder="johndoe@example.com"
                    class="block w-full mt-1"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password"
                    :value="__('Password')" />

                <x-input id="password"
                    placeholder="Password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me"
                    class="inline-flex items-center">
                    <input id="remember_me"
                        type="checkbox"
                        class="border-gray-300 rounded shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-2">
                <x-button class="w-full">
                    {{ __('Log in') }}
                </x-button>
            </div>

            <div class="flex flex-col-reverse justify-between mt-4 md:flex-row md:items-center">
                @if (Route::has('register'))
                    <a class="text-sm text-gray-600 underline hover:text-gray-900"
                        href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                @endif
                <div>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
