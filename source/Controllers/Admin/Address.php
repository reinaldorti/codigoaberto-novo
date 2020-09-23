<?php

namespace Source\Controllers\Admin;

use Source\Support\Message;

/**
 * Class Address
 * @package Source\Controllers\Admin
 */
class Address extends Admin
{
    /**
     * Dash constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ADMIN TELA ADDRES CREATE/UPDATE
     * @param array|null $data
     * @param \Source\Models\Address
     */
    public function address(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $form = [$data["zipcode"], $data["street"], $data["number"], $data["district"], $data["city"]];
        if (in_array("", $form)) {
            echo Message::ajaxResponse("message", [
                "type" => "error",
                "message" => "
                    <i class='icon fas fa-ban'></i>
                    Oops! Por favor, preencha todos os campos (*) obrigatórios!
                "
            ]);
            return;
        }

        if (!csrf_verify($data['csrf_token'])) {
            echo Message::ajaxResponse("message", [
                "type" => "alert",
                "message" => "  
                    <i class='icon fas fa-exclamation-triangle'></i>            
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
            ]);
            return;
        }

        $addr = (!empty($data['id']) ? (new \Source\Models\Address())->findById($data['id']) : new \Source\Models\Address());
        $addr->user_id = $data['user_id'];
        $addr->zipcode = $data['zipcode'];
        $addr->street = mb_convert_case($data['street'], MB_CASE_TITLE);
        $addr->number = $data['number'];
        $addr->complement = (!empty($data['complement']) ? mb_convert_case($data['complement'], MB_CASE_TITLE) : "Não informado");
        $addr->district = mb_convert_case($data['district'], MB_CASE_TITLE);
        $addr->city = mb_convert_case($data['city'], MB_CASE_TITLE);
        $addr->state = mb_convert_case($data['state'], MB_CASE_TITLE);
        $addr->country = (!empty($data['country']) ? mb_convert_case($data['country'], MB_CASE_TITLE) : "Brasil");
        $addr->save();

        echo Message::ajaxResponse("message", [
            "type" => "success",
            "message" => "<i class='icon fas fa-check'></i> Endereço atualizado com sucesso!",
            "clear" => [
                "clear" => true,
            ],
        ]);
        return;
    }
}