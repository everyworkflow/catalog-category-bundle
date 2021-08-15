<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\Controller\Admin;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntityInterface;
use EveryWorkflow\CoreBundle\Annotation\EWFRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveCategoryController extends AbstractController
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
     *     name="admin.catalog.category.save",
     *     methods="POST"
     * )
     */
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ('create' === $uuid) {
            /** @var CatalogProductEntityInterface $item */
            $item = $this->catalogCategoryRepository->getNewEntity($submitData);
        } else {
            $item = $this->catalogCategoryRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }
        $result = $this->catalogCategoryRepository->saveEntity($item);

        if ($result->getUpsertedId()) {
            $item->setData('_id', $result->getUpsertedId());
        }

        return (new JsonResponse())->setData([
            'message' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
