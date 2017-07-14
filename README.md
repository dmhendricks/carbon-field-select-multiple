# Carbon Field: Select Multiple

The future home of Carbon_Field_Select_Multiple. **This currently does not work.**

### Requirements

* [Carbon Fields 2](https://github.com/htmlburger/carbon-fields)


## Example Usage

Add the following to composer.json:

```
"repositories": [
   {
      "type": "vcs",
      "url": "https://github.com/dmhendricks/carbon-field-select-multiple.git"
   }
],
"require": {
  "php": ">=5.3.2",
  "mnsami/composer-custom-directory-installer": "~1.1.0",
  "htmlburger/carbon-fields": "^2.0.0",
  "dmhendricks/carbon-field-select2": "*",
  "composer/installers": "^1.3.0"
},
"extra": {
  "installer-paths": {
    "./vendor/htmlburger/carbon-fields": ["htmlburger/carbon-fields"]
  }
}
```
