<?php

namespace Omnipay\MercadoPago\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://api.mercadopago.com/v1/payments/';
    /** @var this option is unavailable */
    protected $testEndpoint = 'https://api.mercadopago.com/v1/payments/';


    public function getData()
    {
        //get information about collection
        $id = $this->httpRequest->query->get('collection_id');
        $url = $this->getEndpoint() . "$id?access_token=" . $this->getAccessToken();
        $httpRequest = $this->httpClient->request(
            'GET',
            $url,
            array(
                'Content-type' => 'application/json',
            )
        );
        $response = $httpRequest->getBody()->getContents();
        return json_decode($response, true);
    }

    public function sendData($data)
    {
        return $this->createResponse($data);
    }

    protected function createResponse($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

}

?>
