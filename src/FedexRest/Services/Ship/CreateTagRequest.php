<?php


namespace FedexRest\Services\Ship;


use FedexRest\Entity\Person;
use FedexRest\Exceptions\MissingAccountNumberException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Ship\Type\ServiceType;

class CreateTagRequest extends AbstractRequest
{
    protected int $account_number;
    protected Person $shipper;
    protected array $recipients;
    protected string $service_type;
    protected string $ship_datestamp = '';

    /**
     * @inheritDoc
     */
    public function setApiEndpoint()
    {
        return '/ship/v1/shipments/tag';
    }

    /**
     * @param  string  $ship_datestamp
     * @return CreateTagRequest
     */
    public function setShipDatestamp(string $ship_datestamp)
    {
        $this->ship_datestamp = $ship_datestamp;
        return $this;
    }


    /**
     * @param  mixed  $service_type
     * @return CreateTagRequest
     */
    public function setServiceType(string $service_type)
    {
        $this->service_type = $service_type;
        return $this;
    }

    /**
     * @return ServiceType
     */
    public function getServiceType(): string
    {
        return $this->service_type;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @return Person
     */
    public function getShipper(): Person
    {
        return $this->shipper;
    }

    /**
     * @param  Person  $shipper
     * @return $this
     */
    public function setShipper(Person $shipper): CreateTagRequest
    {
        $this->shipper = $shipper;
        return $this;
    }

    /**
     * @param  Person  ...$recipients
     * @return $this
     */
    public function setRecipients(Person ...$recipients): CreateTagRequest
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @param  int  $account_number
     * @return $this
     */
    public function setAccountNumber(int $account_number): CreateTagRequest
    {
        $this->account_number = $account_number;
        return $this;
    }

    /**
     * @return array[]
     */
    public function prepare()
    {
        return [
            'json' => [
                'requestedShipment' => [
                    'shipper' => $this->shipper->prepare(),
                    'recipients' => array_map(fn(Person $person) => $person->prepare(), $this->recipients),
                    'shipDatestamp' => $this->ship_datestamp,
                    'pickupType' => 'CONTACT_FEDEX_TO_SCHEDULE',
                    'serviceType' => $this->service_type,
                    'packagingType' => 'YOUR_PACKAGING',
                    'shippingChargesPayment' => [
                        'paymentType' => 'SENDER',
                        'payor' => [
                            'responsibleParty' => [
                                'accountNumber' => [
                                    'value' => $this->account_number,
                                ],
                            ],
                        ],
                    ],
                    'shipmentSpecialServices' => [
                        'specialServiceTypes' => [
                            'RETURN_SHIPMENT',
                        ],
                        'returnShipmentDetail' => [
                            'returnType' => 'FEDEX_TAG',
                        ],
                    ],
                    'blockInsightVisibility' => false,
                    'pickupDetail' => [
                        'readyPickupDateTime' => (new \DateTime(date('Y-m-d H:i:s')))
                                ->modify('+3 day')
                                ->format('Y-m-d').'T09:00:00Z',
                        'latestPickupDateTime' => (new \DateTime(date('Y-m-d H:i:s')))
                                ->modify('+3 day')
                                ->format('Y-m-d').'T14:00:00Z',
                    ],
                    'requestedPackageLineItems' => [
                        [
                            'itemDescription' => 'Item description',
                            'weight' => [
                                'units' => 'LB',
                                'value' => 5,
                            ],
                        ],
                    ],
                ],
                'accountNumber' => [
                    'value' => $this->account_number,
                ],
            ]
        ];
    }

    public function request()
    {
        parent::request();
        if (empty($this->account_number)) {
            throw new MissingAccountNumberException('The account number is required');
        }

        return $this->http_client->post($this->getApiUri($this->api_endpoint), $this->prepare());
    }

}
