<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\fields\MultiSelect;
use craft\helpers\Cp;

/**
 * This field extends the Craft `MultiSelect` field type and allows users to select specific sections
 * from the CMS. Available sections can be configured via field settings, by default all sections are available.
 *
 * @package honcho\sectionsfield\fields
 * @author Honcho <dev@honcho.agency>
 * @license MIT
 * @link https://honcho.agency/
 */
class SectionsField extends MultiSelect
{
    public ?array $allowedSections = null;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('app', 'Sections');
    }

    /**
     * Retrieves all sections or filters them by specific section IDs.
     *
     * @param array<int>|null $sectionIds An optional array of section IDs to filter the results. If null, all sections are returned.
     * @return array An array of section objects.
     */
    public static function getSections(?array $sectionIds = null): array
    {
        $sections = Craft::$app->entries->allSections ?? [];

        if ($sectionIds) {
            $sections = array_filter($sections, function ($section) use ($sectionIds) {
                return in_array($section->id, $sectionIds);
            });
        }

        return $sections ?? [];
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
        $sections = $this->getSections($this->allowedSections);
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
        $sections = $this->getSections();

        return Cp::checkboxGroupFieldHtml([
            'label' => Craft::t('app', 'Allowed Sections'),
            'name' => 'allowedSections',
            'options' => array_map(function ($section) {
                return [
                    'label' => $section->name,
                    'value' => (string) $section->id,
                ];
            }, $sections),
            'values' => $this->allowedSections ?? [],
        ]);
    }
}
