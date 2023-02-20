<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventoryReservations\Model\ResourceModel;

use Magento\InventoryReservations\Model\ResourceModel\GetReservationsQuantity;
use Magento\InventoryReservationsApi\Model\GetReservationsQuantityInterface;

/**
 * @inheritdoc
 */
class GetReservationsQuantityCache implements GetReservationsQuantityInterface
{
    /**
     * @var GetReservationsQuantity
     */
    private $getReservationsQuantity;
    /**
     * @var array
     */
    private $reservationsQuantity = [];
    /**
     * @param GetReservationsQuantity $getReservationsQuantity
     */
    public function __construct(
        GetReservationsQuantity $getReservationsQuantity
    ) {
        $this->getReservationsQuantity = $getReservationsQuantity;
    }
    /**
     * @inheritdoc
     */
    public function execute(string $sku, int $stockId): float
    {
        if (!isset($this->reservationsQuantity[$sku][$stockId])) {
            $this->reservationsQuantity[$sku][$stockId] = $this->getReservationsQuantity->execute($sku, $stockId);
        }
        return $this->reservationsQuantity[$sku][$stockId];
    }

    public function cleanCache(): void
    {
        $this->reservationsQuantity = [];
    }
}
