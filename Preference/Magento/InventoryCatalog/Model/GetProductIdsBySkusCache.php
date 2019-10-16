<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventoryCatalog\Model;

use Magento\InventoryCatalog\Model\GetProductIdsBySkus;
use Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * @inheritdoc
 */
class GetProductIdsBySkusCache implements GetProductIdsBySkusInterface
{
    /**
     * @var GetProductIdsBySkus
     */
    private $getProductIdsBySkus;
    /**
     * @var Json
     */
    private $jsonSerializer;
    /**
     * @var array
     */
    private $productIdsBySkus = [];
    /**
     * @param GetProductIdsBySkus $getProductIdsBySkus
     * @param Json $jsonSerializer
     */
    public function __construct(
        GetProductIdsBySkus $getProductIdsBySkus,
        Json $jsonSerializer
    ) {
        $this->getProductIdsBySkus = $getProductIdsBySkus;
        $this->jsonSerializer = $jsonSerializer;
    }
    /**
     * @inheritdoc
     */
    public function execute(array $skus): array
    {
        $cacheKey = $this->jsonSerializer->serialize($skus);
        if (!isset($this->productIdsBySkus[$cacheKey])) {
            $this->productIdsBySkus[$cacheKey] = $this->getProductIdsBySkus->execute($skus);
        }
        return $this->productIdsBySkus[$cacheKey];
    }
}
