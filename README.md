# GenyBundle

Goal of this bundle is to provide:
- a user interface to create forms
- a user interface to render and validate those forms

# WARNING: under development! POCs, etc...

## What is it?

There are tons of ideas where admin may need to draw a form, set a template (not necessarily a view) and then final user can give the context by filling the form.
This way, user's context is mixed to admin's template and, according to a website's goal, do some stuff without any programming needs.

Some websites examples:
- a highly-dynamic back end: admin define sql query/linux command templates and the context form: and users can run those query/commands after filling that form.
- a code generator: user define templates and forms to complete the context, and then just need to fill it as much times as he want.
- ...

## Warning

From the Symfony documentation:

> A bundle should not embed third-party libraries written in JavaScript, CSS or any other language.

As this bundle contains a complex UI, it was too challenging for me to do it without jQuery and Twitter Bootstrap.

They are not included in the bundle.

## Installation

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require <package-name> "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new <vendor>\<bundle-name>\<bundle-long-name>(),
        );

        // ...
    }

    // ...
}
```



[See the documentation](Resources/doc/install.md)

## Usage

## How does it work?

For now, only the text input really works ! Well, more or less...
