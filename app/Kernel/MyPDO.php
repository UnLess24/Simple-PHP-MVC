<?php

namespace App\Kernel;


class MyPDO extends \PDO
{

    /**
     * MyPDO constructor.
     */

    public function __construct($file = null)
    {
        if (! $file) {
            $file = get_include_path() . real_path('/app/config/db.ini');
        }
        if (! $settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];

        parent::__construct(
            $dns,
            $settings['database']['username'],
            $settings['database']['password'],
            [
                \PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }
}
