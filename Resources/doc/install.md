
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
            new GenyBundle\GenyBundle(),
        );
    }
```

3) Register the routing in your `app/config/routing.yml`

```yml
geny:
    resource: "@GenyBundle/Controller/"
    type:     annotation
    prefix:   /geny
```
