# Static Fake Design Bundle

## Features

Add the following syntax in your twig template to generate variable with a fake value
```
{# @fake variable_name value_type }
```
The variable is generated only when a variable with the same name doesn't exist
The available value types are (some type accept parameters) :
- audio
- block
- breadcrumb
- content
- coordinates
- form
- image
- link
- pager
- richtext
- taxonomy_entry
- video

[full documentation (coming soon)](/)

## Installation

Require the package with `composer require erdnaxelaweb/staticfakedesign:dev-main` then activate the bundle :
```injectablephp
ErdnaxelaWeb\StaticFakeDesignBundle\StaticFakeDesignBundle::class => ['all' => true],
```

### Routing
Add the following root to access the examples :
```yaml
static:
    path: /static/{path}
    controller: ErdnaxelaWeb\StaticFakeDesignBundle\Controller\StaticController::viewAction
    requirements:
        path: .*
```

## Create your own value generator

coming soon
