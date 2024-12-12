<div style="margin:0;padding:0" bgcolor="#f7f7fa">
    <div style="background-color:#f7f7fa; padding:20px;" align="center">
        <table cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto">
            <tbody>
            <tr>
                <td style="padding:20px 15px 10px" align="center" bgcolor="#fff">
                    <a href="<?= url(); ?>">
                        <img src="<?= asset('assets/img/logo.png'); ?>" width="400" height="120" alt="<?= CONF_SITE["NAME"]; ?>">
                    </a>
                </td>
            </tr>
            <tr>
                <td style="margin-bottom:15px" align="left" bgcolor="#fff">
                    <div style="padding:20px">
                        <p style="color:#383838;font-size:16px; line-height:1.45em; margin-top:16px; margin-bottom:16px;">
                            <strong style='font-size:17px'>Prezado(a), {$user->first_name}! É importante!</strong> <br>
                            Detectamos um novo acesso á sua conta do " . CONF_SITE['NAME'] . "!
                            Foi efetuado a partir de uma rede de IP ou dispositivo diferente do habitual, confira se foi você:<br><br>

                            <b>IP:</b> <?= $ip; ?><br>
                            <b>Data:</b> " . date('d/m/Y H:i:s') . "<br><br>

                            <b>NÃO FOI VOCÊ?</b><br> É importante atualizar sua conta o quanto antes para manter seus dados seguros.<br> Para isso é preciso aterar sua senha.<br><br>
                            <b>FOI VOCÊ?</b><br> Então pode ignorar este e-mail, mas ele sempre será enviado como medida de segurança para que você tenha certeza que está tudo certo com sua conta.<br>
                            Como você sabe, nela existem seus dados pessoais.<br><br>

                            <b>DÚVIDAS, CRÍTICAS OU SUGESTÕES?</b> <br>
                            Estamos sempre à disposição para melhor atendê-los! Você sempre pode contar com nossa equipe de suporte!<br><br>

                        <p> — Atenciosamente " . CONF_SITE['NAME'] . "</p>
                        </p>
                    </div>
                </td>
            </tr>
            <tr bgcolor="#fff">
                <td align="center" bgcolor="#fff">
                    <a title="<?= $button; ?>" href="<?= $link; ?>" style="color: #ffffff!important; display: inline-block; font-weight: 500; font-size: 16px; line-height: 42px; width: auto; white-space: nowrap; min-height: 42px; margin: 12px 5px 12px 0; padding: 0 22px; text-decoration: none; text-align: center!important; border: 0; border-radius: 3px; vertical-align: top; background-color: #5d5d5d!important" target="_blank">
                        <span style="display: inline; text-decoration: none; font-weight: 500; font-style: normal; font-size: 16px; line-height: 42px; border: none; color: #ffffff!important">
                            <?= $button; ?>
                        </span>
                    </a>
                </td>
            </tr>
            <tr>
                <td style="display:block; max-width:600px;margin:15px auto 0" align="center">
                    <div style="background-color:#fff; margin-bottom:15px;padding:32px 20px;">
                        <h3 style="margin-top:0; font-style:normal;margin-bottom:0; font-size:24px; font-weight:400; line-height:1.45em;color:#a4a4a4;">
                            Seguir a <?= CONF_SITE["NAME"]; ?>
                        </h3>
                        <center style="padding:24px 0;">
                            <table style="border-collapse:collapse">
                                <tbody>
                                <tr>
                                    <td style="padding:0 10px;'" align="center">
                                        <a href="<?= CONF_SOCIAL['FACEBOOK_PAGE']; ?>" style="color:#333; text-decoration:underline;width:50px; padding:0;" target="_blank">
                                            <img src="<?= asset('assets/img/facebook.png'); ?>" width="45" height="45"/>
                                        </a>
                                    </td>

                                    <td style="padding:0 10px;" align="center">
                                        <a href="<?= CONF_SOCIAL['INSTAGRAM_PAGE']; ?>"
                                           style="color:#333; text-decoration:underline; width:50px;padding:0;" target="_blank">
                                            <img src="<?= asset('assets/img/instagram.png'); ?>" width="45" height="45"/>
                                        </a>
                                    </td>

                                    <td style="padding:0 10px;" align="center">
                                        <a href="<?= CONF_SOCIAL['TWITTER_PAGE']; ?>"
                                           style="color:#333; text-decoration:underline;width:50px; padding:0;" target="_blank">
                                            <img src="<?= asset('assets/img/twitter.png'); ?>" width="45" height="45"/>
                                        </a>
                                    </td>

                                    <td style="padding:0 10px;" align="center">
                                        <a href="<?= CONF_SOCIAL['YOUTUBE_PAGE']; ?>"
                                           style="color:#333; text-decoration:underline; width:50px; padding:0;" target="_blank">
                                            <img src="<?= asset('assets/img/youtube.png'); ?>" width="45" height="45"/>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </center>

                        <p style="color:#a4a4a4; font-size:12px; line-height:16px;margin:12px 0 10px; ">
                            <b><?= CONF_SITE["NAME"]; ?></b> © 2020, Todos os direitos reservados.<br>

                            <b>
                                Telefone/Whatsapp: <?= CONF_MAIL["FROM_WHATSAPP"]; ?><br/>
                                E-mail: <?= CONF_MAIL["FROM_EMAIL"]; ?><br/><br/>
                                <?= CONF_SITE["ADDR_STREET"]; ?>, <?= CONF_SITE["ADDR_NUMBER"]; ?><br/>
                                Bairro: <?= CONF_SITE["ADDR_DISTRICT"]; ?> <br/> Cidade: <?= CONF_SITE["ADDR_CITY"]; ?>
                                / <?= CONF_SITE["ADDR_STATE"]; ?>
                            </b>
                        </p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

