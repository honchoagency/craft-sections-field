<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\fieldlayoutelements\BaseField;
use craft\elements\Entry;
use craft\helpers\Cp;

class SectionsChipField extends Field
{
    public static function displayName(): string
    {
        return Craft::t('app', 'Sections Field');
    }

    public static function getSections(): array
    {
        return Craft::$app->entries->allSections;
    }

    function getInputHtml(mixed $value, ?ElementInterface $element): string
    {
        return '<textarea name="foo">' . $value . '</textarea>';
    }
}
