<?php

namespace codemonauts\buttons\resources;

use codemonauts\buttons\Buttons;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use Craft;

class CustomAssets extends AssetBundle
{
    public function init()
    {
        $cssFile = Buttons::getInstance()->getSettings()->cssFile;

        if ($cssFile != '') {
            $file = Craft::getAlias($cssFile);
            $this->sourcePath = pathinfo($file, PATHINFO_DIRNAME);

            $this->depends = [
                CpAsset::class,
            ];

            $this->css = [
                pathinfo($file, PATHINFO_BASENAME),
            ];
        }

        parent::init();
    }
}
