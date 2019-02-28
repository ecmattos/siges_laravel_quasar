
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}  - Confirmação de cadastro 
        @endcomponent
    @endslot

    {{-- Body --}}
    
    Olá, {{ $client->name }} !

    Obrigado por registrar-se conosco.
    
    Estamos enviando o código de verificação abaixo para que você possa concluir o seu cadastro.
    
    Código de verificação: {{ $client->code_verification }}
    
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
