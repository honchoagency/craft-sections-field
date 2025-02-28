<?php

namespace honcho\sectionsfield\fields;

use Craft;
use craft\base\ElementInterface;
use craft\fields\MultiSelect;
use craft\helpers\Cp;
use honcho\sectionsfield\data\SectionData;
use honcho\sectionsfield\data\SectionsFieldData;

/**
 * This field extends the Craft `MultiSelect` field type and allows users to select specific sections
 * from the CMS. Available sections can be configured via field settings, by default all sections are available.
 *
 * @package honcho\sectionsfield\fields
 * @author Honcho Agency <dev@honcho.agency>
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
     * Retrieves all sections or filters them by specific section handles.
     *
     * @param array<string>|null $sectionHandles An optional array of section Handles to filter the results. If null, all sections are returned.
     * @return array An array of section objects.
     */
    public static function getSections(?array $sectionHandles = null): array
    {
        $sections = Craft::$app->entries->allSections ?? [];

        if ($sectionHandles) {
            $sections = array_filter($sections, function ($section) use ($sectionHandles) {
                return in_array($section->handle, $sectionHandles);
            });
        }

        return $sections ?? [];
    }

    /**
     * @inheritdoc
     */
    public static function icon(): string
    {
        $iconPath = Craft::getAlias('@honcho/sectionsfield/resources/field-icon.svg');

        if (file_exists($iconPath)) {
            return file_get_contents($iconPath);
        }

        return 'newspaper';
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
                'value' => (string) $section->handle,
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
                    'value' => (string) $section->handle,
                ];
            }, $sections),
            'values' => $this->allowedSections ?? [],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element): mixed
    {
        if ($value instanceof SectionsFieldData) {
            return $value;
        }

        $value = parent::normalizeValue($value, $element);
        $options = $value->getOptions();
        $sections = [];
        $selectedOptions = [];

        foreach ((array) $options as $option) {
            $sectionName = $option->label;
            $sectionHandle = $option->value;
            $sectionId = Craft::$app->entries->getSectionByHandle($sectionHandle)->id;
            $sectionData = new SectionData(
                $sectionName,
                $sectionHandle,
                $sectionId,
                $option->selected ?? false,
                $option->valid ?? true
            );

            $sections[] = $sectionData;

            if ($option->selected) {
                $selectedOptions[] = $sectionData;
            }
        }

        $value = new SectionsFieldData($selectedOptions);
        $value->setSections($sections);

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue(mixed $value, ?ElementInterface $element): mixed
    {
        if ($value instanceof SectionsFieldData) {
            $serialized = [];

            foreach ($value->getSections() as $option) {
                if ($option->selected) {
                    $serialized[] = $option->value;
                }
            }

            return $serialized;
        }

        return parent::serializeValue($value, $element);
    }
}
