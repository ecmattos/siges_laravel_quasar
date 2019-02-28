
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}  - Confirmação de cadastro de Usuário
        @endcomponent
    @endslot

    {{-- Body --}}
    
    Olá, {{ $user->name }} !

    Recebemos a solicitação de cadastro de um novo usuário.
    
    Segue abaixo os seus dados:
    
    Nome: {{ $user->name }}
    e-mail: {{ $user->email }}
    Perfil: {{ $user->role }}
    
    Senha inicial de acesso: "secret" (sem as aspas)
    
    Atenciosamente,

    {{ client->name }}


    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
    @endcomponent
@endslot
@endcomponent
