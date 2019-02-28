@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}  - Recuperação da Senha de Acesso 
        @endcomponent
    @endslot

    {{-- Body --}}
    
    Olá, {{ $user->name }} !

    Recebemos a sua solicitação de recuperação de Senha de Acesso.
    
    Segue abaixo o código de verificação para fins criar um novo acesso:
    
    Código de verificação: {{ $user->code_verification }}
    
    Caso você não tenha solicitado, favor desconsiderar este e-mail.
    
    Atenciosamente,

    {{ config('app.name') }}


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