<?php

return [
    /*
     * An optional CSS file, that will be bundled and published for the control panel, when a button group is used.
     * There can only be one CSS file for all button groups.
     *
     * You would normaly use something like '@config/buttons/style.css'.
     */
    'cssFile' => '',

    /*
     * In addition to a local file, you can set an URL for an external CSS (e.g. Fontawesome)
     */
    'cssUrl' => '',

    /*
     * This array sets the config for all button groups. The array key is the button group's handle.
     * See the examples in the repository.
     *
     * E.g.:
     *
     * 'buttonGroups' => [
     *   'myhandle' => [
     *     'name' => 'My awesome buttons', // The name in the field's configuration dialog
     *     'buttons' => [
     *       'handle-button-1' => [
     *         'image' => '@buttonsAssets/myimage.jpg', // Optional Image, overwrites 'label'
     *         'title' => 'My button 1', // Title and Alt Attributes
     *         'value' => 'myvalue', // The value to store (string)
     *         'class' => 'myclass', // Optional class to add to the button
     *         'label' => 'Abc', // The button's text, will be overwritten when an image is set
     *       ],
     *       'handle-button-2' => [
     *        ...
     *       ],
     *       ...
     *     ],
     *   ],
     * ],
     */
    'buttonGroups' => [],
];
