# GenyBundle

Goal of this project is to provide:
- a user interface to create forms
- a user interface to display and validate those forms

# WARNING: under development!

## What is it?

There are tons of ideas where admin may need to draw a form, set a template (not necessarily a view) and then final user can give the context by filling the form.
This way, user's context is mixed to admin's template and, according to a website's goal, do some stuff without any programming needs.

Some websites examples:
- a highly-dynamic back end: admin define sql query/linux command templates and the context form: and users can run those query/commands after filling that form.
- a code generator: user define templates and forms to complete the context, and then just need to fill it as much times as he want.
- ...

To make this possible, I need to:
- define what's a form inside a configuration file
- create tools to take that file and display/validate a form
- create tools to display a friendly form to generate that file (thus, forms)

Why would I use a configuration file between the form creator and the form renderer?
- if a form can be stored inside a json file, it can be easily stored on a database/shared through apis...
- as this "form format" will be generic, it will be possible to make those forms compatible with mobile devices

## Installation

1) Download the bundle

```sh
php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar require ninsuo/GenyBundle
```

2) Register the bundle in your `app/AppKernel.php`

```php
    public function registerBundles()
    {
        $bundles = array(

            // ...
            new Fuz\GenyBundle\FuzGenyBundle(),
        );
    }
```

3) Register the routing in your `app/config/routing.yml`

```yml
geny:
    resource: "@FuzGenyBundle/Controller/"
    type:     annotation
    prefix:   /geny
```

## Usage

## How does it work?

I define each type, each option and each validation constraint as a form that can be rendered and validated.

This way:
- I can render a form to generate forms using the very same code as the one that generates forms
- I can validate a json form representation by using the same validators used to validate forms

About the implementation, I'll use Symfony's form and validator components.

### Let's take an example...

We create a simple text field having a length constraint between 10 and 20 characters:

```json
{
    "simple_string": {
        "type": "text",
        "options": {
            "label": "a simple text field"
        },
        "validation": {
            "Length": {
                "min": "10",
                "max": "20"
            }
        }
    }
}
```

a) Options

In our example, we are applying one option, `"label"`:

```
"a simple text field"
```

This simple string comes from the following form:

```json
{
    "label": {
        "type": "text",
        "options": {
            "label": "Enter a label"
        }
    }
}
```

b) Validation

In our example, we are applying one validation constraint, `"Length"`:

```json
{
    "min": "10",
    "max": "20"
}
```

Which is an object that come from the following form:

```json
{
    "name": "Length",
    "type": "structure",
    "fields": {
        "min": {
            "type": "text",
            "options": {
                "label": "Minimal value"
            },
            "validation": {
                "Type": {
                    "type": "integer"
                }
            }
        },
        "max": {
            "type": "text",
            "options": {
                "label": "Maximal value"
            },
            "validation": {
                "Type": {
                    "type": "integer"
                }
            }
        }
    }
}
```

Type being an object coming from:

```json
{
    "name": "Type",
    "type": "structure",
    "fields": {
        "type": {
            "type": "choice",
            "options": {
                "choices": ["array", "bool", "float", "double", "integer", "null", "numeric", "object", "scalar", "string"],
                "label": "Required data type"
            },
            "validation": {
                "choice": {
                    "choices": ["array", "bool", "float", "double", "integer", "null", "numeric", "object", "scalar", "string"]
                }
            }
        }
    }
}
```

Choice being an object coming from:

```json
{
    "name": "choice",
    "type": "structure",
    "fields": {
        "choices": {
            "type": "collection",
            "options": {
                "label": "choices"
            },
            "validation": {
                "type": {
                    "type": "array"
                }
            },
            "fields": {
                "choice": {
                    "type": "text",
                    "options": {
                        "label": "New choice"
                    },
                    "validation": {
                        "type": {
                            "type": "string"
                        }
                    }
                }
            }
        }
    }
}
```

c) Field type
