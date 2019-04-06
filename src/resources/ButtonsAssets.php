<?php

namespace codemonauts\buttons\resources;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class ButtonsAssets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = '@codemonauts/buttons/resources';

        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'css/style.css',
        ];

        parent::init();
    }
}
