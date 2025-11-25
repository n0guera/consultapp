<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Credential; // Importar el modelo Credential
use App\Models\User;     // Importar el modelo User
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    // 1. Extraer el nombre de usuario de la parte izquierda del email
    // Si el usuario escribe "nutricionista@cualquiercosa.com", esta línea obtiene "nutricionista"
    $inputEmail = $this->get('email');
    $usernameToSearch = explode('@', $inputEmail)[0]; 

    // 2. Buscar las Credenciales usando el username extraído
    $credential = Credential::where('username', $usernameToSearch)->first();

    // 3. Verificar si se encontró el username Y si el hash de la contraseña es correcto
    if (!$credential || !Hash::check($this->get('password'), $credential->password)) {
        RateLimiter::hit($this->throttleKey());
        throw ValidationException::withMessages([
            // Usamos 'email' para que el mensaje aparezca bajo el campo de email del formulario
            'email' => trans('auth.failed'), 
        ]);
    }

    // 4. Buscar el modelo User asociado e iniciar sesión
    $user = User::where('credential_id', $credential->id)->first();

    if (!$user) {
        RateLimiter::hit($this->throttleKey());
        throw ValidationException::withMessages(['email' => 'Error de mapeo de usuario.']);
    }

    Auth::login($user, $this->boolean('remember'));

    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
