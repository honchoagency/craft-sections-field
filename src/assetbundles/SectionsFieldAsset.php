<?php

namespace honcho\sectionsfield\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class SectionsFieldAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = "@honcho/sectionsfield/resources/dist";
        $this->depends = [CpAsset::class];
        $this->js = ['sections-field.js'];
        $this->css = ['sections-field.css'];

        parent::init();
    }
}
