<?php

namespace codemonauts\buttons\fields\conditions;

use codemonauts\buttons\Buttons;
use craft\base\conditions\BaseMultiSelectConditionRule;
use craft\fields\BaseOptionsField;
use craft\fields\conditions\FieldConditionRuleInterface;
use craft\fields\conditions\FieldConditionRuleTrait;
use craft\fields\data\MultiOptionsFieldData;
use craft\fields\data\OptionData;
use craft\fields\data\SingleOptionFieldData;
use Illuminate\Support\Collection;

/**
 * Options field condition rule.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.0.0
 */
class ButtonsFieldConditionRule extends BaseMultiSelectConditionRule implements FieldConditionRuleInterface
{
    use FieldConditionRuleTrait;

    protected function options(): array
    {
        $field = $this->_field;
        $group = Buttons::getInstance()->getSettings()->buttonGroups[$field->configHandle];

        $options = [];
        foreach ($group['buttons'] as $handle => $button) {
            $options[] = [
                'value' => $button['value'],
                'label' => $button['title'] ?? $button['label'] ?? $handle,
            ];
        }

        return $options;
    }

    /**
     * @inheritdoc
     */
    protected function elementQueryParam(): array
    {
        return $this->paramValue();
    }

    /**
     * @inheritdoc
     */
    protected function matchFieldValue($value): bool
    {
        if ($value instanceof MultiOptionsFieldData) {
            /** @phpstan-ignore-next-line */
            $value = array_map(fn(OptionData $option) => $option->value, (array)$value);
        } elseif ($value instanceof SingleOptionFieldData) {
            $value = $value->value;
        }

        return $this->matchValue($value);
    }
}
