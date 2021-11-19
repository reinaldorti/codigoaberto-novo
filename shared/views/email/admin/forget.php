
<?php $v->layout("../_theme", ["title" => $subject]); ?>

<p><strong style='font-size:17px'>Prezado(a), <?= $user->first_name; ?>! Perdeu sua senha?</strong></p>

<p>Você está recebendo este e-mail pois foi solicitado a recuperação de senha no site do <?= CONF_SITE["NAME"]; ?>.</p>

<p>
    <b>IMPORTANTE:</b> Se não foi você que solicitou ignore o e-mail. Seus dados permanecem seguros.
</p>

<p>
    <b>SUGESTÕES?</b>
    Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!
</p>

<p>...</p>
<p>Este e-mail automático não deve ser respondido!</p>
<p><em> — Atenciosamente: <?= CONF_SITE["NAME"]; ?></em></p>