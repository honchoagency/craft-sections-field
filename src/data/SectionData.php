<?php

namespace honcho\sectionsfield\data;

use craft\base\Serializable;
use craft\fields\data\OptionData;

/**
 * Class SectionData
 *
 * @package honcho\sectionsfield\data
 * @author Honcho Agency <dev@honcho.agency>
 * @license MIT
 * @link https://honcho.agency/
 */
class SectionData extends OptionData implements Serializable
{
    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string|null
     */
    public ?string $handle = null;

    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * @var bool
     */
    public bool $selected;

    /**
     * @var bool
     */
    public bool $valid;

    /**
     * Constructor
     *
     * @param string|null $name
     * @param string|null $handle
     * @param int|null $id
     * @param bool $selected
     * @param bool $valid
     */
    public function __construct(?string $name, ?string $handle, ?int $id, bool $selected, bool $valid = true)
    {
        $this->handle = $handle;
        $this->id = $id;
        $this->label = $name;
        $this->name = $name;
        $this->selected = $selected;
        $this->valid = $valid;
        $this->value = $handle;
    }

    /**
     * @inheritdoc
     */
    public function serialize(): mixed
    {
        return [
            'handle' => $this->handle,
            'id' => $this->id,
            'label' => $this->name,
            'name' => $this->name,
            'selected' => $this->selected,
            'valid' => $this->valid,
            'value' => $this->handle,
        ];
    }
}
