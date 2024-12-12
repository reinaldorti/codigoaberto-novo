
<?php $v->layout("../_theme", ["title" => $subject]); ?>

<strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>! É importante!</strong> <br/>
Detectamos um novo acesso á sua conta no nosso site <?= CONF_SITE["NAME"]; ?>!
Foi efetuado a partir de uma rede de IP ou dispositivo diferente do habitual, confira se foi você:<br/><br/>

<b>IP:</b> <?= $ip; ?><br/>
<b>Data:</b> <?= date("d/m/Y", strtotime($user->lastaccess)); ?><br/><br/>

<b>NÃO FOI VOCÊ?</b><br/> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br/> Para isso <b>ACESSE SUA CONTA</b> e altere sua senha.<br/><br/>
<b>FOI VOCÊ?</b><br/> Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br/>
Como você sabe, nela existem seus dados pessoais.<br/><br/>

<b>DICA:</b><br/> Não compartilhe sua conta com ninguém, lembre-se que você é o único responsável por manter seus dados de acesso seguro.<br/><br/>
<b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br/><br/>

<p>...</p>
<p>Este e-mail automático não deve ser respondido!</p>
<p><em> — Atenciosamente: <?= CONF_SITE["NAME"]; ?></em></p>