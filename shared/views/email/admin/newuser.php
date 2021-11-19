<?php $v->layout("../_theme", ["title" => $subject]); ?>

<p style="color:#383838;font-size:16px; line-height:1.45em; margin-top:16px; margin-bottom:16px;">
    <strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>!</strong> <br>
    Sua conta acaba de ser criada no site  <?= CONF_SITE["NAME"]; ?>!<br><br>

    <b>DADOS DE ACESSO:</b>
    <p>
        <b>E-mail:</b> <?= $user->email; ?><br/>
        <b>Senha:</b> <b style='color:#FF0000; font-family: Consolas; font-weight:bold;'><?= $password; ?></b>
    </p>

    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
    Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br><br>

    <p> — Atenciosamente <?= CONF_SITE["NAME"]; ?></p>
</p>
