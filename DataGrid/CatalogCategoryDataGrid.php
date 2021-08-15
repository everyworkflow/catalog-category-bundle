<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\DataGrid;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Factory\ActionFactoryInterface;
use EveryWorkflow\DataGridBundle\Model\Action\ButtonAction;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;

class CatalogCategoryDataGrid extends DataGrid implements CatalogCategoryDataGridInterface
{
    protected DataObjectFactoryInterface $dataObjectFactory;
    protected CatalogCategoryRepositoryInterface $catalogCategoryRepository;
    protected ActionFactoryInterface $actionFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        DataGridConfigInterface $dataGridConfig,
        FormInterface $form,
        ArraySourceInterface $source,
        DataObjectFactoryInterface $dataObjectFactory,
        CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        ActionFactoryInterface $actionFactory,
    ) {
        parent::__construct($dataObject, $dataGridConfig, $form, $source);
        $this->dataObjectFactory = $dataObjectFactory;
        $this->catalogCategoryRepository = $catalogCategoryRepository;
        $this->actionFactory = $actionFactory;
    }

    public function getConfig(): DataGridConfigInterface
    {
        $config = parent::getConfig();

        $allColumns = ['_id'];
        foreach ($this->catalogCategoryRepository->getAttributes() as $attribute) {
            if ($attribute->isUsedInGrid() && !isset($allColumns[$attribute->getCode()])) {
                $allColumns[] = $attribute->getCode();
            }
        }
        foreach (['status', 'created_at', 'updated_at'] as $item) {
            if (!isset($allColumns[$item])) {
                $allColumns[] = $item;
            }
        }

        $config->setIsFilterEnabled(true)
            ->setIsColumnSettingEnabled(true)
            ->setActiveColumns($allColumns)
            ->setSortableColumns($allColumns)
            ->setFilterableColumns($allColumns);

        $config->setHeaderActions([
            $this->actionFactory->create(ButtonAction::class, [
                'path' => '/catalog/category/create',
                'label' => 'Create new',
            ]),
        ]);

        $config->setRowActions([
            $this->actionFactory->create(ButtonAction::class, [
                'path' => '/catalog/category/{_id}/edit',
                'label' => 'Edit',
            ]),
            $this->actionFactory->create(ButtonAction::class, [
                'path' => '/catalog/category/{_id}/delete',
                'label' => 'Delete',
            ]),
        ]);

        $config->setBulkActions([
            $this->actionFactory->create(ButtonAction::class, [
                'path' => '/catalog/category/enable/{_id}',
                'label' => 'Enable',
            ]),
            $this->actionFactory->create(ButtonAction::class, [
                'path' => '/catalog/category/disable/{_id}',
                'label' => 'Disable',
            ]),
        ]);

        return $config;
    }

    public function getForm(): FormInterface
    {
        return $this->catalogCategoryRepository->getForm();
    }
}
