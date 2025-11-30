<x-guest-layout>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-center items-center self-stretch gap-2">
        <x-lucide-apple class="w-5 h-5" />
        <p class="h-5 text-base text-center text-slate-900">
            ConsultApp
        </p>
    </div>
    <div class="flex flex-col justify-start items-start self-stretch gap-1.5">
        <div class="flex flex-col justify-start items-center self-stretch">
            <p class="text-lg text-center text-slate-900">
                Iniciar Sesión en ConsultApp
            </p>
        </div>
        <div class="flex flex-col justify-start items-center self-stretch">
            <p class="text-sm text-center text-gray-400">
                Accede para gestionar tu Agenda y Pacientes
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col w-full gap-2.5">
        @csrf

        <!-- Email Address -->
        <div class="flex flex-col gap-1.5">
            <x-input-label for="email" value="Correo Electrónico" class="text-slate-900" />
            <div class="flex items-center">
                <x-lucide-mail class="ml-3 w-4 h-4 text-gray-400 absolute" />
                <x-text-input id="email" class="pl-8 rounded-xl block w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="nombre@correo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-1.5">
            <x-input-label for="password" value="Contraseña" class="text-slate-900" />
            <div class="flex items-center">
                <x-lucide-lock class="ml-3 w-4 h-4 text-gray-400 absolute" />
                <x-text-input id="password" class="pl-8 rounded-xl block w-full" type="password" name="password"
                    required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

        </div>

        <!-- Remember Me -->
        <div class="flex justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="w-4 h-4 rounded-md bg-white border border-zinc-200 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-slate-900">Recuérdame</span>
            </label>
            @if (Route::has('password.request'))
                <a class="flex justify-start items-center gap-1.5 px-3 py-2 text-sm rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    <x-lucide-circle-question-mark class="w-4 h-4" />
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit"
            class="flex justify-center items-center self-stretch gap-2 px-3 py-3 rounded-xl bg-teal-600">
            <x-lucide-log-in class="w-4 h-4 text-white" />
            <p class="text-sm text-center text-white">
                Iniciar Sesión
            </p>
        </button>
    </form>
    <p class="self-stretch text-xs text-center text-gray-400">
        v1.0
    </p>
</x-guest-layout>
