<?php

namespace FedexRest\Services\Ship\Entity;

use FedexRest\Entity\Weight;

class Commodity
{

    protected string $description;
    protected int $numberOfPieces;
    protected string $countryOfManufacture;
    protected string $quantityUnits;
    protected string $name;
    protected string $harmonizedCode;
    protected string $partNumber;
    protected Weight $weight;
    protected int $quantity;
    protected Value $customsValue;
    protected Value $unitPrice;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Commodity
    {
        $this->description = $description;
        return $this;
    }

    public function getNumberOfPieces(): int
    {
        return $this->numberOfPieces;
    }

    public function setNumberOfPieces(int $numberOfPieces): Commodity
    {
        $this->numberOfPieces = $numberOfPieces;
        return $this;
    }

    public function getCountryOfManufacture(): string
    {
        return $this->countryOfManufacture;
    }

    public function setCountryOfManufacture(string $countryOfManufacture): Commodity
    {
        $this->countryOfManufacture = $countryOfManufacture;
        return $this;
    }

    public function getQuantityUnits(): string
    {
        return $this->quantityUnits;
    }

    public function setQuantityUnits(string $quantityUnits): Commodity
    {
        $this->quantityUnits = $quantityUnits;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Commodity
    {
        $this->name = $name;
        return $this;
    }

    public function getHarmonizedCode(): string
    {
        return $this->harmonizedCode;
    }

    public function setHarmonizedCode(string $harmonizedCode): Commodity
    {
        $this->harmonizedCode = $harmonizedCode;
        return $this;
    }

    public function getPartNumber(): string
    {
        return $this->partNumber;
    }

    public function setPartNumber(string $partNumber): Commodity
    {
        $this->partNumber = $partNumber;
        return $this;
    }

    public function getWeight(): Weight
    {
        return $this->weight;
    }

    public function setWeight(Weight $weight): Commodity
    {
        $this->weight = $weight;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Commodity
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getCustomsValue(): Value
    {
        return $this->customsValue;
    }

    public function setCustomsValue(Value $customsValue): Commodity
    {
        $this->customsValue = $customsValue;
        return $this;
    }

    public function getUnitPrice(): Value
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(Value $unitPrice): Commodity
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
    
    public function prepare(): array
    {
        $data = [];
        if (!empty($this->description)) {
            $data['description'] = $this->description;
        }
        if (!empty($this->numberOfPieces)) {
            $data['numberOfPieces'] = $this->numberOfPieces;
        }
        if (!empty($this->countryOfManufacture)) {
            $data['countryOfManufacture'] = $this->countryOfManufacture;
        }
        if (!empty($this->quantityUnits)) {
            $data['quantityUnits'] = $this->quantityUnits;
        }
        if (!empty($this->name)) {
            $data['name'] = $this->name;
        }
        if (!empty($this->harmonizedCode)) {
            $data['harmonizedCode'] = $this->harmonizedCode;
        }
        if (!empty($this->weight)) {
            $data['weight'] = $this->weight->prepare();
        }
        if (!empty($this->quantity)) {
            $data['quantity'] = $this->quantity;
        }
        if (!empty($this->customsValue)) {
            $data['customsValue'] = $this->customsValue->prepare();
        }
        if (!empty($this->unitPrice)) {
            $data['unitPrice'] = $this->unitPrice->prepare();
        }
        return $data;
    }
}
