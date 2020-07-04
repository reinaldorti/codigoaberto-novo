<div style="width: 500px; max-width: 100%; padding: 10px; font-family: 'Trebuchet MS', sans-serif; font-size: 1.2em;">
    <h4>Prezado(a),  <?= $user->first_name; ?>! Tudo certo?</h4>
    <p>
        Sua senha foi redefinida com sucesso!
    </p>

    <b>IP:</b> <?= $ip; ?> <br/>
    <b>Data:</b> <?= date('d/m/Y H:i:s'); ?><br/><br/>

    <b>NÃO FOI VOCÊ?</b><br/> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br/> Para isso <b>ACESSE SUA CONTA</b> e altere sua senha.<br/><br/>
    <b>FOI VOCÊ?</b><br/> Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br/>
    Como você sabe, nela existem seus dados pessoais.<br/><br/>
    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br/>

    <p><a href="<?= $link; ?>" title="Acessar conta">Acessar conta</a></p>
    <p>Atenciosamente <?= CONF_SITE['NAME']; ?></p>
</div>