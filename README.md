# Creating a new Carbon Field

Step-by-step guide on how to create a new Carbon Field.

## Introduction

The [Carbon Fields](https://github.com/htmlburger/carbon-fields) library has many built-in fields, but you may find it necessary to define a new type of field for your specific project needs.

The following tutorial will explain how to create a custom Carbon Field.

### Step 1: Download the template

To make it as easy as possible, we have prepared a Carbon Field template that contains a frame for the PHP Carbon Field class and a webpack build process.

You can download the template from here: https://github.com/htmlburger/carbon-field-template

Template Structure

- `/assets/css` - css folder
- `/assets/js` - JavaScript files folder
- `/languages` - folder for .po, .mo and .pot files
- `/core` - folder for all of your .php files
- `/field.php` - bootstrapping php code

### Step 2: Name your field

Replace the `YOURFIELDNAME` and `yourfieldname` (case sensitive) placeholders in all files. Also rename the files that contain the placeholders.

**NB!** If your field name contains multiple words, for example Image Gallery, your class names should look like this:

* **PHP class:** `Image_Gallery_Field`
* **React Component Registration:** `image_gallery` (refer to `registerFieldComponent`@`/assets/js/bootstrap.js`)

### Step 3: Build assets

1. Edit `webpack.config.js` and make sure `const root` points to the directory where Carbon Fields are installed (e.g. `const root = path.resolve(__dirname, '../vendor/includes/htmlburger/carbon-fields');` )
1. Execute `npm install` in the root directory to install all build process requirements.
1. Execute `npm run build` to build the final minimized assets

##### Optional

Execute `npm run dev` to continuously build assets during development. Note that you should add `define( 'SCRIPT_DEBUG', true );` to your `wp-config.php` file in order to load the files generated by the dev build process.

### Step 4: Customize

Here is a quick overview of some of the methods you can customize:

#### PHP

`to_json()`

You can use this method to modify the field properties that are added to the JSON object.

The JSON object is used by the Backbone Model and the Underscore template.

`field_type_activated`

Used for initialization processes that are called once per field type (e.g. setup localization files).

`admin_enqueue_scripts()`

Used to enqueue CSS/JavaScript files.

`admin_init()`

Called for each field instance when the field is initialized. (back-end)

`init()`

Called for each field instance when the field is initialized. (back-end, front-end)
