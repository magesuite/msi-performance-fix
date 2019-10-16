<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventorySales\Model;

use Magento\InventorySales\Model\GetAssignedSalesChannelsForStock;
use Magento\InventorySalesApi\Model\GetAssignedSalesChannelsForStockInterface;

/**
 * @inheritdoc
 */
class GetAssignedSalesChannelsForStockCache implements GetAssignedSalesChannelsForStockInterface
{
    /**
     * @var GetAssignedSalesChannelsForStock
     */
    private $getAssignedSalesChannelsForStock;
    /**
     * @var array
     */
    private $salesChannelsAssignedToStocks = [];
    /**
     * @param GetAssignedSalesChannelsForStock $getAssignedSalesChannelsForStock
     */
    public function __construct(
        GetAssignedSalesChannelsForStock $getAssignedSalesChannelsForStock
    ) {
        $this->getAssignedSalesChannelsForStock = $getAssignedSalesChannelsForStock;
    }
    /**
     * @inheritdoc
     */
    public function execute(int $stockId): array
    {
        if (!isset($this->salesChannelsAssignedToStocks[$stockId])) {
            $this->salesChannelsAssignedToStocks[$stockId] = $this->getAssignedSalesChannelsForStock->execute($stockId);
        }
        return $this->salesChannelsAssignedToStocks[$stockId];
    }
}
