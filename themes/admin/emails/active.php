<div style="width: 500px; max-width: 100%; padding: 10px; font-family: 'Trebuchet MS', sans-serif; font-size: 1.2em;">

    <strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>!</strong> <br/>
    Sua conta ainda não esta ativa!<br/>
    Estamos entrando em contato pois ainda você não ativou sua conta em nosso site.<br/><br/>

    <b>IMPORANTE</b>:<br/> Caso não tenha efetuado esta solicitação basta ignorar este e-mail.<br/><br/>

    <b>ATENÇÃO!</b> Para acessar sua conta é preciso ativar sua conta antes...<b><br/><br/>

    <a href="<?= $link; ?>" >ATIVAR CONTA!</a></b><br/><br/>

    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Você sempre pode contar com nossa equipe en

    <p>Atenciosamente <?= CONF_SITE['NAME']; ?></p>
</div>