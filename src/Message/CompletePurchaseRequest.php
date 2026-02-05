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
        // Support both webhook (transactionReference) and callback (collection_id query string)
        $id = $this->getTransactionReference() ?: $this->httpRequest->query->get('collection_id');

        if (empty($id)) {
            throw new \InvalidArgumentException('Payment ID not found. Provide transactionReference parameter or collection_id in query string.');
        }

        $url = $this->getEndpoint() . "{$id}?access_token=" . $this->getAccessToken();

        \Illuminate\Support\Facades\Log::debug("CompletePurchaseRequest URL: {$url}");

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
