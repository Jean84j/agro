<?php

namespace frontend\widgets;

use app\widgets\BaseWidgetFronted;

class CategoriesAuxiliary extends BaseWidgetFronted
{

    public $auxiliaryCategories;

    public function init()
    {
        parent::init();

    }

    public function run() {

        $auxiliaryCategories = $this->auxiliaryCategories;

        return $this->render('categories-auxiliary',
            [
                'auxiliaryCategories' => $auxiliaryCategories,
            ]);
    }


}
