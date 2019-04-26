# Boot Manager for Cockpit CMS

## Features

* load modules in a specific order
* load modules only if you need them (api calls don't need to load admin ui addons)

## Installation

Copy this repository into `/addons` and name it `BootManager` or

```bash
cd path/to/cockpit
git clone https://github.com/raffaelj/cockpit_BootManager.git addons/BootManager
```

## Usage

Disable all available modules and addons in `config/config.yaml`, except the BootManager Addon, e. g.:

```yaml
modules.disabled:
    - Collections
    - Singletons
    - Forms
    - phpLiteAdmin
    - EditorFormats
    - FormValidation
    - Helpers
    - Logger
    - SelectRequestOptions
    - UniqueSlugs
```

Now specify the modules, you want to load.

Global option for all use cases:

```yaml
bootmanager:
    global:
        - Collections
        - Singletons
        - Forms
        - UniqueSlugs
```

Load different modules for admin ui, api request or when using Cockpit as a library.

```yaml
bootmanager:
    ui:
        - Logger
        - Collections
        - Singletons
        - Forms
        - UniqueSlugs
        - phpLiteAdmin
    api:
        - Collections
        - Singletons
    lib:
        - Collections
        - Singletons
        - Forms
    cli:
        - Collections
        - Singletons
        - Forms
```


## To do:

* thinking about implementing it to the core
* Boot Manager UI
* rewrite to object oriented module style (makes an optional UI much easier)
* maybe granular options for user groups or specific routes
* thinking about a real addon manager
