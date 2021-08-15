<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle;

use EveryWorkflow\CatalogCategoryBundle\DependencyInjection\CatalogCategoryExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EveryWorkflowCatalogCategoryBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CatalogCategoryExtension();
    }
}
