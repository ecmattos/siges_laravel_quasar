<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Olá, {{ $user->name }} !
    <br>
    <br>
    Obrigado por registrar-se conosco no site da ???????? com este e-mail, estamos enviando essa mensagem apenas para que você possa concluir o seu cadastro.
    <br>
    <br>
    Por favor, copie o código de verificação: <b><b> 
    <br>
    <br>
    Caso você não tenha realizado este cadastro, favor desconsiderar este e-mail.
    <br/>
    <a href="{{url('user/verify', $user->code_verification)}}">Verify Email</a>
    <br/>
    Atenciosamente,
    Equipe ????????
</div>

</body>
</html>
