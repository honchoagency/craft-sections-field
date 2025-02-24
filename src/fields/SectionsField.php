<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use honcho\sectionsfield\assetbundles\SectionsFieldAsset;

class SectionsField extends Field
{
    public static function displayName(): string
    {
        return Craft::t('app', 'Sections Field Custom');
    }

    public static function getSections(): array
    {
        return Craft::$app->entries->allSections;
    }

    function getInputHtml(mixed $value, ?ElementInterface $element): string
    {
        Craft::$app->view->registerAssetBundle(SectionsFieldAsset::class);

        return Craft::$app->view->renderTemplate('sections-field/fields/sections-field', [
            'name' => $this->handle,
            'id' => $this->handle . '-' . uniqid(),
            'value' => $value,
            'sections' => $this->getSections(),
        ]);
    }
}
