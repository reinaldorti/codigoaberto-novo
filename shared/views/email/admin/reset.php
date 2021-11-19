
<?php $v->layout("../_theme", ["title" => $subject]); ?>

<p><strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>! Tudo certo?</strong></p>

<p>Sua senha foi redefinida com sucesso!</p>
<p>
    <b>IP:</b> <?= $_SERVER["REMOTE_ADDR"]; ?><br>
    <b>Data:</b> <?= date("d/m/Y H:i:s"); ?><br>
</p>

<p>
    <b>NÃO FOI VOCÊ?</b><br> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br>
    Para isso clique em ACESSE SUA CONTA e altere sua senha.
</p>

<p>
    <b>FOI VOCÊ?</b><br>
    Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br>
    Como você sabe, nela existem seus dados pessoais.
</p>

<p>
    <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
    Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!
</p>

<p>...</p>

<p>Este e-mail automático não deve ser respondido!</p>
<p><em> — Atenciosamente: <?= CONF_SITE["NAME"]; ?></em></p>