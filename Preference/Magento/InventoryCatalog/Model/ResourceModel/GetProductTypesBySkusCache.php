<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventoryCatalog\Model\ResourceModel;

use Magento\InventoryCatalog\Model\ResourceModel\GetProductTypesBySkus;
use Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * @inheritdoc
 */
class GetProductTypesBySkusCache implements GetProductTypesBySkusInterface
{
    /**
     * @var GetProductTypesBySkus
     */
    private $getProductTypesBySkus;
    /**
     * @var Json
     */
    private $jsonSerializer;
    /**
     * @var array
     */
    private $productTypesBySkus = [];
    /**
     * @param GetProductTypesBySkus $getProductTypesBySkus
     * @param Json $jsonSerializer
     */
    public function __construct(
        GetProductTypesBySkus $getProductTypesBySkus,
        Json $jsonSerializer
    ) {
        $this->getProductTypesBySkus = $getProductTypesBySkus;
        $this->jsonSerializer = $jsonSerializer;
    }
    /**
     * @inheritdoc
     */
    public function execute(array $skus): array
    {
        $cacheKey = $this->jsonSerializer->serialize($skus);
        if (!isset($this->productTypesBySkus[$cacheKey])) {
            $this->productTypesBySkus[$cacheKey] = $this->getProductTypesBySkus->execute($skus);
        }
        return $this->productTypesBySkus[$cacheKey];
    }
}
