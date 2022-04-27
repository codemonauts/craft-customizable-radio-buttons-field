<?php

namespace codemonauts\buttons\fields;

use codemonauts\buttons\fields\conditions\ButtonsFieldConditionRule;
use codemonauts\buttons\resources\ButtonsAssets;
use codemonauts\buttons\resources\CustomAssets;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Cp;
use LitEmoji\LitEmoji;
use codemonauts\buttons\Buttons as Plugin;

class Buttons extends Field implements PreviewableFieldInterface
{
    /**
     * @var array Default values for buttons
     */
    protected array $defaultButton = [
        'image' => '',
        'label' => '',
        'class' => '',
        'title' => '',
        'value' => '',
    ];

    /**
     * @var string Button handle
     */
    public string $configHandle = '';

    /**
     * @var string Default value
     */
    public string $defaultValue = '';

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
    public function getSettingsHtml(): ?string
    {
        $options = [];
        $buttonGroups = Plugin::getInstance()->getSettings()->buttonGroups;
        foreach ($buttonGroups as $handle => $group) {
            $options[] = [
                'label' => $group['name'],
                'value' => $handle,
            ];
        }

        $html = Cp::selectFieldHtml([
            'label' => Craft::t('buttons', 'Button group'),
            'instructions' => Craft::t('buttons', 'The button group from the config file to use.'),
            'id' => 'configHandle',
            'name' => 'configHandle',
            'options' => $options,
            'value' => $this->configHandle,
        ]);

        $html .= Cp::textFieldHtml([
            'label' => Craft::t('buttons', 'Default value'),
            'instructions' => Craft::t('buttons', 'The default value of the field. If empty, no button will be preselected.'),
            'id' => 'defaultValue',
            'name' => 'defaultValue',
            'value' => $this->defaultValue,
        ]);

        return $html;
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $group = Plugin::getInstance()->getSettings()->buttonGroups[$this->configHandle];

        if ($settings->cssUrl !== '') {
            Craft::$app->getView()->registerCssFile($settings->cssUrl);
        }

        $buttons = [];
        foreach ($group['buttons'] as $handle => $button) {
            $fieldHandle = $this->handle . '-' . $handle;
            $buttons[$fieldHandle] = array_merge($this->defaultButton, $button);
            if ($buttons[$fieldHandle]['image'] !== '') {
                $buttons[$fieldHandle]['image'] = Craft::$app->assetManager->getPublishedUrl($buttons[$fieldHandle]['image'], true);
            }
        }

        Craft::$app->getView()->registerAssetBundle(ButtonsAssets::class);
        Craft::$app->getView()->registerAssetBundle(CustomAssets::class);

        return Craft::$app->getView()->renderTemplate('buttons/input', [
            'name' => $this->handle,
            'value' => $value ?? $this->defaultValue,
            'field' => $this,
            'buttons' => $buttons,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function serializeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        if ($value !== null) {
            $value = LitEmoji::unicodeToShortcode($value);
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getSearchKeywords(mixed $value, ElementInterface $element): string
    {
        $value = (string)$value;

        return LitEmoji::unicodeToShortcode($value);
    }

    /**
     * @inheritdoc
     */
    public function getElementConditionRuleType(): ?string
    {
        return ButtonsFieldConditionRule::class;
    }
}
