<?php
/**
 * L10n library
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('L10n', 'I18n');

/**
 * Class HuradL10n
 */
class HuradL10n
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Get available locales in locale directory
     *
     * @return array
     * @throws CakeException
     */
    public static function getAvailableLocale()
    {
        if (!is_dir(APP . 'Locale')) {
            throw new CakeException('Locale directory not exist.');
        }

        $dir = new Folder(APP . 'Locale');

        if (!$dir->read()[0]) {
            throw new CakeException('Locale not exist.');
        }

        $availableCatalog = [];
        $l10n = new L10n();

        foreach ($dir->read()[0] as $locale) {
            $poFile = new File(APP . 'Locale' . self::DS . $locale . self::DS . 'LC_MESSAGES' . self::DS . 'hurad.po');

            if ($poFile->exists()) {
                $catalog = $l10n->catalog($locale);

                if ($catalog) {
                    $availableCatalog[$locale] = $catalog;
                }
            }
        }

        $availableCatalog = Hash::merge(['eng' => $l10n->catalog('eng')], $availableCatalog);

        return $availableCatalog;
    }
}
