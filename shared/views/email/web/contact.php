
<?php $v->layout("../_theme", ["title" => $subject]); ?>

<strong style="font-size:17px">Prezado(a), <?= CONF_SITE["NAME"]; ?>!</strong><br/>
Você acaba de receber uma nova mensagem via site.<br/><br/>
<strong>Nome: </strong><?= $data["name"]; ?><br/>
<strong>E-mail: </strong><?= $data["email"]; ?><br/>
<strong>Assunto: </strong><?= $data["subject"]; ?><br/>
<strong>Mensagem:</strong><br/> <?= $data["message"]; ?><br/> <br/>
<b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br/>Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br/><br/>

<p>...</p>
<p>Este e-mail automático não deve ser respondido!</p>
<p><em> — Atenciosamente: <?= CONF_SITE["NAME"]; ?></em></p>