<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\Inventory\Model\Source\Command;

use Magento\Inventory\Model\Source\Command\GetSourcesAssignedToStockOrderedByPriority;
use Magento\InventoryApi\Api\GetSourcesAssignedToStockOrderedByPriorityInterface;

/**
 * @inheritdoc
 */
class GetSourcesAssignedToStockOrderedByPriorityCache implements GetSourcesAssignedToStockOrderedByPriorityInterface
{
    /**
     * @var GetSourcesAssignedToStockOrderedByPriority
     */
    private $getSourcesAssignedToStock;
    /**
     * @var array
     */
    private $sourcesAssignedToStock = [];
    /**
     * @param GetSourcesAssignedToStockOrderedByPriority $getSourcesAssignedToStockOrderedByPriority
     */
    public function __construct(
        GetSourcesAssignedToStockOrderedByPriority $getSourcesAssignedToStockOrderedByPriority
    ) {
        $this->getSourcesAssignedToStock = $getSourcesAssignedToStockOrderedByPriority;
    }
    /**
     * @inheritdoc
     */
    public function execute(int $stockId): array
    {
        if (!isset($this->sourcesAssignedToStock[$stockId])) {
            $this->sourcesAssignedToStock[$stockId] = $this->getSourcesAssignedToStock->execute($stockId);
        }
        return $this->sourcesAssignedToStock[$stockId];
    }
}