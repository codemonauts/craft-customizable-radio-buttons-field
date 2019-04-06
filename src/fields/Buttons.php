<?php

namespace codemonauts\buttons\fields;

use codemonauts\buttons\resources\ButtonsAssets;
use codemonauts\buttons\resources\CustomAssets;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use LitEmoji\LitEmoji;
use codemonauts\buttons\Buttons as Plugin;

class Buttons extends Field implements PreviewableFieldInterface
{
    /**
     * @var array Default values for buttons
     */
    protected $defaultButton = [
        'image' => '',
        'label' => '',
        'class' => '',
        'title' => '',
        'value' => '',
    ];

    /**
     * @var string Button handle
     */
    public $configHandle = '';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('buttons', 'Customizable Radio Buttons');
    }

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $options = [];
        $buttonGroups = Plugin::getInstance()->getSettings()->buttonGroups;
        foreach ($buttonGroups as $handle => $group) {
            $options[] = [
                'label' => $group['name'],
                'value' => $handle,
            ];
        }

        return Craft::$app->getView()->renderTemplateMacro('_includes/forms', 'selectField', [
            [
                'label' => Craft::t('buttons', 'Button group'),
                'id' => 'configHandle',
                'name' => 'configHandle',
                'options' => $options,
                'value' => $this->configHandle,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $group = Plugin::getInstance()->getSettings()->buttonGroups[$this->configHandle];

        if ($settings->cssUrl !== '') {
            Craft::$app->getView()->registerCssFile($settings->cssUrl);
        }

        $buttons = [];
        foreach ($group['buttons'] as $handle => $button) {
            $buttons[$handle] = array_merge($this->defaultButton, $button);
            if ($buttons[$handle]['image'] !== '') {
                $buttons[$handle]['image'] = Craft::$app->assetManager->getPublishedUrl($buttons[$handle]['image'], false);
            }
        }

        Craft::$app->getView()->registerAssetBundle(ButtonsAssets::class);
        Craft::$app->getView()->registerAssetBundle(CustomAssets::class);

        return Craft::$app->getView()->renderTemplate('buttons/input', [
            'name' => $this->handle,
            'value' => $value,
            'field' => $this,
            'buttons' => $buttons,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if ($value !== null) {
            $value = LitEmoji::unicodeToShortcode($value);
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getSearchKeywords($value, ElementInterface $element): string
    {
        $value = (string)$value;
        $value = LitEmoji::unicodeToShortcode($value);

        return $value;
    }
}
