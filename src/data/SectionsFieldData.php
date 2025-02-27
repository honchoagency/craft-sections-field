<?php

namespace honcho\sectionsfield\data;

use Craft;
use craft\fields\data\MultiOptionsFieldData;
use InvalidArgumentException;

/**
 * Sections field data class.
 *
 * @package honcho\sectionsfield\data
 * @author Honcho <dev@honcho.agency>
 * @license MIT
 * @link https://honcho.agency/
 */
class SectionsFieldData extends MultiOptionsFieldData
{
    /**
     * @var SectionData[] Array of section data objects.
     */
    private array $_sections = [];

    /**
     * Returns the names of the selected sections.
     *
     * @return array Array of section names.
     */
    public function names()
    {
        return $this->getSelectedSectionsAsProperties('name');
    }

    /**
     * Returns the handles of the selected sections.
     *
     * @return array Array of section handles.
     */
    public function handles()
    {
        return $this->getSelectedSectionsAsProperties('handle');
    }

    /**
     * Returns the IDs of the selected sections.
     *
     * @return array Array of section IDs.
     */
    public function ids()
    {
        return $this->getSelectedSectionsAsProperties('id');
    }

    /**
     * Returns the selected sections as Craft section objects.
     *
     * @return array Array of Craft section objects.
     */
    public function sections()
    {
        return array_map(function ($section) {
            return Craft::$app->entries->getSectionByHandle($section->handle);
        }, $this->getSelectedSections());
    }

    /**
     * Returns the selected sections' properties.
     *
     * @param string $property The property to retrieve.
     * @return array Array of selected sections' properties.
     * @throws InvalidArgumentException If the property does not exist on SectionData.
     */
    private function getSelectedSectionsAsProperties($property)
    {
        if (!property_exists(SectionData::class, $property)) {
            throw new InvalidArgumentException("Property '{ $property }' does not exist on type SectionData");
        }

        return array_values(array_map(function ($section) use ($property) {
            return $section->$property;
        }, $this->getSelectedSections()));
    }

    /**
     * Returns the selected sections.
     *
     * @return SectionData[] Array of selected section data objects.
     */
    private function getSelectedSections()
    {
        return array_filter($this->_sections, function ($section) {
            return $section->selected;
        });
    }

    /**
     * Returns the sections.
     *
     * @return SectionData[] Array of section data objects.
     */
    public function getSections(): array
    {
        return $this->_sections;
    }

    /**
     * Sets the sections.
     *
     * @param SectionData[] $sections Array of section data objects.
     */
    public function setSections(array $sections): void
    {
        $this->_sections = $sections;
    }
}
