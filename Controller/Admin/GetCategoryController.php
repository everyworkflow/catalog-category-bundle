<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller\Admin;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetCategoryController extends AbstractController
{
    protected CatalogCategoryRepositoryInterface $catalogCategoryRepository;

    public function __construct(CatalogCategoryRepositoryInterface $catalogCategoryRepository)
    {
        $this->catalogCategoryRepository = $catalogCategoryRepository;
    }

    /**
     * @EWFRoute(
     *     admin_api_path="catalog/category/{uuid}",
     *     defaults={"uuid"="create"},
     *     name="admin.catalog.category.view",
     *     methods="GET"
     * )
     * @throws \Exception
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = [];

        if ($uuid !== 'create') {
            $item = $this->catalogCategoryRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        $data['data_form'] = $this->catalogCategoryRepository->getForm()->toArray();

        return (new JsonResponse())->setData($data);
    }
}
