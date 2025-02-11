<?php

namespace honcho\sectionsfield;

use Craft;
use craft\base\Plugin;

/**
 * Sections Field plugin
 *
 * @method static SectionsField getInstance()
 * @author Honcho <dev@honcho.agency>
 * @copyright Honcho
 * @license MIT
 */
class SectionsField extends Plugin
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
        Craft::$app->onInit(function() {
            // ...
        });
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
