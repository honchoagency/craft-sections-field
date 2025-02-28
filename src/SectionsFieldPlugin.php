<?php

namespace honcho\sectionsfield;

use Craft;
use yii\base\Event;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use honcho\sectionsfield\fields\SectionsField;

/**
 * Sections Field plugin - adds a new field type to the CMS which allows users to select from a list of sections on the site (multiselect)
 *
 * @method static SectionsField getInstance()
 * @author Honcho Agency <dev@honcho.agency>
 * @link https://honcho.agency/
 * @copyright Copyright (c) 2025 Honcho
 * @license MIT
 */
class SectionsFieldPlugin extends Plugin
{
    public string $schemaVersion = '1.0.0';

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        Craft::$app->onInit(function () {});
    }

    private function attachEventHandlers(): void
    {
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SectionsField::class;
            }
        );
    }
}
