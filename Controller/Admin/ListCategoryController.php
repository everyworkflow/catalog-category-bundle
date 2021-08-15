<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller\Admin;

use EveryWorkflow\CatalogCategoryBundle\DataGrid\CatalogCategoryDataGridInterface;
use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ListCategoryController extends AbstractController
{
    protected CatalogCategoryDataGridInterface $catalogCategoryDataGrid;

    public function __construct(CatalogCategoryDataGridInterface $catalogCategoryDataGrid)
    {
        $this->catalogCategoryDataGrid = $catalogCategoryDataGrid;
    }

    /**
     * @EWFRoute(
     *     admin_api_path="catalog/category",
     *     name="admin.category.product",
     *     priority=10,
     *     methods="GET"
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $dataGrid = $this->catalogCategoryDataGrid->setFromRequest($request);
        return (new JsonResponse())->setData($dataGrid->toArray());
    }
}
