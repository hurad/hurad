::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
::
:: Bake is a shell script for running CakePHP bake script
::
:: PHP 5
::
:: Licensed under The MIT License
:: For full copyright and license information, please see the LICENSE
:: Redistributions of files must retain the above copyright notice.
::
:: @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
:: @link      http://hurad.org Hurad Project
:: @since     Version 0.1.0
:: @license   http://opensource.org/licenses/MIT MIT license
::
::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

:: In order for this script to work as intended, the cake\console\ folder must be in your PATH

@echo.
@echo off

SET app=%0
SET lib=%~dp0

php -q "%lib%cake.php" -working "%CD% " %*

echo.

exit /B %ERRORLEVEL%