<?php


namespace Source\Support;


use ReCaptcha\ReCaptcha;

/**
 * Class GoogleRecaptcha
 * @package Source\Support
 */
class GoogleRecaptcha
{
    /**
     * @param array $data
     * @return bool
     */
    public static function recaptcha(array $data): bool
    {
        $gRecaptchaResponse = filter_var($data['g-recaptcha-response'], FILTER_DEFAULT);
        $remoteIp = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRIPPED);

        $recaptcha = new ReCaptcha(CONF_GOOGLE_RECAPTCHA['secret']);
        $resp = $recaptcha->setExpectedHostname('www.localhost')
            ->verify($gRecaptchaResponse, $remoteIp);
        if (!$resp->isSuccess()) {
            $errors = $resp->getErrorCodes();
            return false;
        }

        // Verified!
        return true;
    }
}