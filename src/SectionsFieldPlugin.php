<?php

namespace honcho\sectionsfield;

use Craft;
use yii\base\Event;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use honcho\sectionsfield\fields\SectionsChipField;
use honcho\sectionsfield\fields\SectionsDropdownField;
use honcho\sectionsfield\fields\SectionsField;

/**
 * Sections Field plugin
 *
 * @method static SectionsField getInstance()
 * @author Honcho <dev@honcho.agency>
 * @copyright Honcho
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

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function () {});
    }

    private function attachEventHandlers(): void
    {
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SectionsDropdownField::class;
            }
        );

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SectionsChipField::class;
            }
        );

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SectionsField::class;
            }
        );
    }
}
