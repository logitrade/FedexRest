<?php

namespace FedexRest\Services\Ship\Entity;

class DutiesPayment
{
    protected string $paymentType;
    protected int $accountNumber;

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return DutiesPayment
     */
    public function setPaymentType(string $paymentType): DutiesPayment
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @return int
     */
    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    /**
     * @param int $accountNumber
     * @return DutiesPayment
     */
    public function setAccountNumber(int $accountNumber): DutiesPayment
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }


    public function prepare(): array
    {
        return [
            'payor' => [
                'responsibleParty' => [
                    'accountNumber' => $this->accountNumber,
                ]
            ],
            'paymentType' => $this->paymentType,
        ];
    }

}