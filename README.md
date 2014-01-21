# Hurad [![Build Status](https://secure.travis-ci.org/hurad/hurad.png)](http://travis-ci.org/hurad/hurad) [![Dependency Status](https://www.versioneye.com/user/projects/52bda689ec13750b1c00007e/badge.png)](https://www.versioneye.com/user/projects/52bda689ec13750b1c00007e) [![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/hurad/hurad/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
Hurad is a free and opensource content managment which is base on [CakePHP](http://cakephp.org) framework under
the [GPL2 License](https://github.com/hurad/hurad/blob/master/LICENSE.txt). Some parts of this system are similar to [WordPress](http://wordpress.org) and some of them got from it.

## Requirements ##

* Apache with mod_rewrite is preferred, but by no means required.
* PHP 5.4 or greater.
* MySQL 4 or greater.

## Installation ##

After cloning this repository you can install dependencies into your new application
in one of two ways:

### Install with composer

1. Download [composer](http://getcomposer.org/doc/00-intro.md).
2. Run `php composer.phar install` to install dependencies.

### Manual installation

1. Clone [CakePHP](https://github.com/cakephp/cakephp) into `/Vendor/pear-pear.cakephp.org/CakePHP`.
2. Clone [Utils](https://github.com/CakeDC/utils) into `/Plugin/Utils`.

You should now be able to visit the path to where you installed Hurad and see the
setup traffic lights.

## Support ##

To report bugs or request features, please visit the [Hurad Issue Tracker](https://github.com/hurad/hurad/issues).

## Branch strategy ##

The master branch holds the STABLE latest version of the plugin.
Develop branch is UNSTABLE and used to test new features before releasing them.

## Contributing to Hurad ##

Please feel free to contribute to the Hurad with new issues, requests, unit tests and code fixes or new features. If you want to contribute some code, create a feature branch from develop, and send us your pull request. Unit tests for new features and issues detected are mandatory to keep quality high.

## Versioning ##

For transparency into our release cycle and in striving to maintain backward compatibility, Hurad is maintained under the Semantic Versioning guidelines. Sometimes we screw up, but we'll adhere to these rules whenever possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

- Breaking backward compatibility **bumps the major** while resetting minor and patch
- New additions without breaking backward compatibility **bumps the minor** while resetting the patch
- Bug fixes and misc changes **bumps only the patch**

For more information on SemVer, please visit <http://semver.org/>.

## Links ##

  * **Official website**: [http://hurad.org](http://hurad.org)
  * **Downloads**: [http://downloads.hurad.org](http://downloads.hurad.org)
  * **Issue Tracker**: [https://github.com/hurad/hurad/issues](https://github.com/hurad/hurad/issues)