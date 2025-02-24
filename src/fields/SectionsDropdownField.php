<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\fields\Dropdown;

class SectionsDropdownField extends Dropdown
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('app', 'Sections Dropdown');
    }

    /**
     * @inheritdoc
     */
    protected function optionsSettingLabel(): string
    {
        return Craft::t('app', 'Sections');
    }

    /**
     * @inheritdoc
     */
    protected function options(): array
    {
        $sections = Craft::$app->entries->allSections;
        $options = array_map(function ($section) {
            return [
                'label' => $section->name,
                'value' => $section->id,
            ];
        }, $sections);

        return $options;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return null;
    }
}
