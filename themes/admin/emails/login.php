<div style="width: 500px; max-width: 100%; padding: 10px; font-family: 'Trebuchet MS', sans-serif; font-size: 1.2em;">

    <strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>! É importante!</strong> <br/>
    Detectamos um novo acesso á sua conta do <?= CONF_SITE['NAME']; ?>!
    Foi efetuado a partir de uma rede de IP ou dispositivo diferente do habitual, confira se foi você:<br/><br/>

    <b>IP:</b> <?= $ip; ?><br/>
    <b>Data:</b> <?= date('d/m/Y H:i:s'); ?><br/><br/>

    <b>NÃO FOI VOCÊ?</b><br/> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br/> Para isso <b>ACESSE SUA CONTA</b> e altere sua senha.<br/><br/>
    <b>FOI VOCÊ?</b><br/> Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br/>
    Como você sabe, nela existem seus dados pessoais.<br/><br/>

    <p><a href="<?= $link; ?>" >ACESSAR CONTA!</a></p><br/><br/>

    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br/><br/>

    <p>Atenciosamente <?= CONF_SITE['NAME']; ?></p>
</div>