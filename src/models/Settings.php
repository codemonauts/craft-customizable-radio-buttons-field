<?php

namespace codemonauts\buttons\models;

use craft\base\Model;

class Settings extends Model
{
    /**
     * @var array The config for all button groups
     */
    public array $buttonGroups = [];

    /**
     * @var string Optional CSS file to bundle
     */
    public string $cssFile = '';

    /**
     * @var string Optional URL to an external CSS
     */
    public string $cssUrl = '';
}
