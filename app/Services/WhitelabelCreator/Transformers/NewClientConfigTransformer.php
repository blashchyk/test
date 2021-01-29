<?php


namespace App\Services\WhitelabelCreator\Transformers;


use App\Services\WhitelabelCreator\Transformers\Contracts\NewClientConfigTransformerInterface;

class NewClientConfigTransformer implements NewClientConfigTransformerInterface
{
    public function transform(array $input, $newId, $data)
    {
        $newSiteName = $data['nameNewSite'];
        $input['id'] = $newId;
        $input['company_name'] = $newSiteName;
        $input['email_name'] = $newSiteName . ' Support';
        $input['client_base_url'] = 'https://' . $newSiteName;
        $input['trustpilot_url'] = 'https://' . $newSiteName;
        $input["client_order_page"] = "http://{$newSiteName}/place-new-order";
        $input["client_orders_page"] = "https://{$newSiteName}/dashboard/orders";
        $input["email"] = "support@{$newSiteName}";
        $input["client_emails_path"] = substr($newSiteName, 0, strpos($newSiteName, "."));
        $input["outer_form_template"] = substr($newSiteName, 0, strpos($newSiteName, "."));
        $input["admin_emails"] = ["support@{$newSiteName}"];
        $input['contacts']['messenger'] = $data['messenger'];
        $input['contacts']['phone'] = $data['phoneNumber'];
        $input['contacts']['phone_formatted'] = $this->transformPhone($data['phoneNumber']);
        $input['contacts']['email'] = $data['email'];
        $input['livechat_group_id']['sales'] = $data['idSales'];
        $input['livechat_group_id']['collectors'] = $data['idCollectors'];
        $input['project_names'] = [
            'xs' => $newSiteName,
            'sm' => $newSiteName,
            'md' => $newSiteName,
            'lg' => $newSiteName,
            'xl' => $newSiteName
        ];
        return $input;
    }

    public function transformPhone($phone)
    {
        $phone = strval(trim($phone, '+'));
        return '+'. substr($phone, 0, 1) . ' ('.substr($phone, 1, 3) . ') '.substr($phone, 4, 3) . '-'.substr($phone, 7, 4);
    }
}

