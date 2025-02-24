<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\fields\MultiSelect;

class SectionsField extends MultiSelect
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('app', 'Sections');
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
                'value' => (string) $section->id,
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
