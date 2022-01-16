/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React from 'react';
import DataFormPageComponent from '@EveryWorkflow/DataFormBundle/Component/DataFormPageComponent';

const CategoryFormPage = () => {
    return (
        <DataFormPageComponent
            title="Category"
            getPath="/catalog/category/{uuid}"
            savePath="/catalog/category/{uuid}"
        />
    );
};

export default CategoryFormPage;
