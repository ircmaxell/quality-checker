<?php

namespace QualityChecker;

class Stats {

    public function getStats($dir) {
        return array(
            'phploc' => $this->getPHPLOC($dir),
        );
    }

    protected function getPHPLOC($dir) {
        $path = realpath(__DIR__ . '/../../../bin/phploc.phar');
        $log = $dir . '/loc.csv';
        $cmd = 'php ' . $path . ' --log-csv '.escapeshellarg($log) . ' '.escapeshellarg($dir);
        shell_exec($cmd);
        $f = fopen($log, 'r');
        if (!$f) {
            throw new \Exception('There was an error running phploc');
        }
        $keys = fgetcsv($f);
        $values = fgetcsv($f);
        fclose($f);
        return array_combine($keys, $values);
    }

}