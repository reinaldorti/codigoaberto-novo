<div style="width: 500px; max-width: 100%; padding: 10px; font-family: 'Trebuchet MS', sans-serif; font-size: 1.2em;">

    <strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>!</strong> <br/>
    Recebemos uma solicitação de cadastro! Sua conta ainda não esta ativa!<br/>
    Estamos entrando em contato pois recebemos uma solicitação do seu e-mail para cadastro em nosso site.<br/><br/>

    <b>IMPORANTE</b>:<br/> Caso não tenha efetuado esta solicitação basta ignorar este e-mail.<br/><br/>

    <b>ATENÇÃO!</b> Para acessar sua conta é preciso ativar sua conta antes...<b><br/><br/>

    <b>DADOS DE ACESSO:</b>
    <p>
        <b>E-mail:</b> <?= $user->email; ?><br/>
        <b>Senha:</b> <?= $password; ?>
    </p>

    <a href="<?= $link; ?>" >ATIVAR CONTA!</a></b><br/><br/>

    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Você sempre pode contar com nossa equipe en

    <p>Atenciosamente <?= CONF_SITE['NAME']; ?></p>
</div>