Graudusk Call Url Module (callurl)
======================================
[![Build Status](https://travis-ci.org/Graudusk/callurl.svg?branch=master)](https://travis-ci.org/Graudusk/callurl)

A module to provide weather data fetched through open APIs.




Install as Anax module
------------------------------------

This is how you install the module into an existing Anax installation.

Install using composer.

```
$ composer require graudusk/callurl
```

Copy the configuration files
----------------------------

```
$ rsync -av vendor/graudusk/callurl/config ./

$ rsync -av vendor/graudusk/callurl/view ./

$ rsync -av vendor/graudusk/callurl/htdocs/ ./htdocs
```


Install using scaffold postprocessing file
------------------------------------

The module supports a postprocessing installation script, to be used with Anax scaffolding. The script executes the default installation, as outlined above.

```text
bash vendor/graudusk/callurl/.anax/scaffold/postprocess.d/100_callurl.bash
```

The postprocessing script should be run after the `composer require` is done.


Install and setup Anax 
------------------------------------

You need a Anax installation, before you can use this module. You can create a sample Anax installation, using the scaffolding utility [`anax-cli`](https://github.com/canax/anax-cli).

Scaffold a sample Anax installation `anax create a ramverk1-me-v2` into the directory `callurl`.

```
$ anax create a ramverk1-me-v2
$ cd callurl
```

Point your webserver to `callurl/htdocs` and Anax should display a Home-page.


License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2018 Eric Johansson, erjh17@student.bth.se
```
