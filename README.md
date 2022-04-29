# Customizable Radio Buttons Field for Craft CMS

![Icon](resources/buttons.png)

A field type that add customizable radio buttons to Craft CMS.

## Background

Pictures say more than many words. With this plugin you can add radio buttons as fields, which can be images, icons, CSS classes, texts or a combination of them.

## Requirements

 * Craft CMS >= 4.0.0

## Installation

Open your terminal and go to your Craft project:

``` shell
cd /path/to/project
composer require codemonauts/craft-customizable-radio-buttons-field
```

In the control panel, go to Settings → Plugins and click the “install” button for *Customizable radio buttons field*.

## Configuration

Copy the ```config.php``` to your config folder as ```buttons.php```. Then add button groups like this:

``` php
<?php

return [
  'cssFile' => '@config/path/to/my.css', // optional path to a local CSS file. This will be automatically published.
  'cssUrl' => 'https://example.com/awesome.css' // Optional URL to an external CSS.
  'buttonGroups' => [
    'myhandle' => [
      'name' => 'My awesome buttons', // The name in the field's configuration dialog.
      'buttons' => [
        'handle-button-1' => [
          'image' => '@buttonsAssets/myimage.jpg', // Optional Image, overwrites 'label'.
          'title' => 'My button 1', // Title and Alt Attributes.
          'value' => 'myvalue', // The value to store (string)
          'class' => 'myclass', // Optional class(es) to add to the button.
          'label' => 'abc', // The button's text, will be overwritten when an image is set.
        ],
        'handle-button-2' => [
          // ...
        ],
        // ...
      ],
      // ...
    ],
  ],
];
``` 

You can have multiple button groups. They all share the same CSS file or CSS URL you can configure. See the [examples](examples/README.md).

With ❤ by [codemonauts](https://codemonauts.com)
