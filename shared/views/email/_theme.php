
<div id=":c7" class="ii gt">
    <div class="a3s aXjCH msg4355981258306707525">
        <div style="margin:0;padding:0" bgcolor="#f7f7fa">
            <div style="font-family:&quot;MaisonNeue&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;background-color:#f7f7fa;padding:20px" align="center">
                <div style="display:none;max-height:0;max-width:0;width:0;height:0;overflow:hidden;font-size:1px;color:#f5f5f5"></div>
                <table cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto">
                    <tbody>
                    <tr>
                        <td style="padding:20px 15px 10px" align="center" bgcolor="#fff">
                            <a href="<?= url(); ?>">
                                <img src="<?= asset("/assets/img/logo.png"); ?>" alt="<?= CONF_SITE["NAME"]; ?>" class="CToWUd">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:&quot;MaisonNeue&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin-bottom:15px" align="left" bgcolor="#fff">
                            <div style="margin-top:0;margin-bottom:0;padding:20px">
                                <p style="color:#383838;font-size:16px;line-height:1.45em;margin-top:16px;margin-bottom:16px">
                                    <?= $v->section("content"); ?>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <tr bgcolor="#fff">
                        <td align="center" bgcolor="#fff">
                            <a title="'<?= $button; ?>" href="<?= $url; ?>" style="color: #ffffff!important; display: inline-block; font-weight: 500; font-size: 16px; line-height: 42px; width: auto; white-space: nowrap; min-height: 42px; margin: 12px 5px 12px 0; padding: 0 22px; text-decoration: none; text-align: center!important; border: 0; border-radius: 3px; vertical-align: top; background-color: #5d5d5d!important" target="_blank">
                                <span style="display: inline; text-decoration: none; font-weight: 500; font-style: normal; font-size: 16px; line-height: 42px; border: none; color: #ffffff!important"><?= $button; ?></span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="display:block;font-family:&quot;MaisonNeue&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;max-width:600px;margin:15px auto 0" align="center">
                            <div style="background-color:#fff;font-family:&quot;MaisonNeue&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin-bottom:15px;padding:32px 20px">
                                <h3 style="margin-top:0;font-family:&quot;MaisonNeue&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-style:normal;margin-bottom:0;font-size:24px;font-weight:400;line-height:1.45em;color:#a4a4a4">Seguir a <?= CONF_SITE["NAME"]; ?></h3>
                                <center style="padding:24px 0">
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
    </div>
</div>