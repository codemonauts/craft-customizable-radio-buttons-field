<?php

namespace codemonauts\buttons\resources;

use codemonauts\buttons\Buttons;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use Craft;

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
