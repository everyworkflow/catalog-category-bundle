<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Repository;

use EveryWorkflow\CatalogCategoryBundle\Entity\CatalogCategoryEntity;
use EveryWorkflow\CoreBundle\Annotation\RepoDocument;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;

/**
 * @RepoDocument(doc_name=CatalogCategoryEntity::class)
 */
class CatalogCategoryRepository extends BaseEntityRepository implements CatalogCategoryRepositoryInterface
{
    protected string $collectionName = 'catalog_category_entity_collection';
    protected array $indexNames = ['path'];
    protected string $entityCode = 'catalog_category';
}
