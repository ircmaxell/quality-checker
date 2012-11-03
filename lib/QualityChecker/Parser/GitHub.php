<?php

namespace QualityChecker\Parser;

use ezcArchive;

class GitHub {
    
    public function getDirectory($url) {
        $data = file_get_contents(rtrim($url, '/') . '/archive/master.tar.gz');
        $tmp = __DIR__ . "/../../../tmp/gh_";
        do {
            $tmp .= rand(0, 99);
        } while (is_dir($tmp));
        mkdir($tmp);
        file_put_contents($tmp . '.tgz', $data);
        $archive = @ezcArchive::open($tmp . '.tgz');
        while ($archive->valid()) {
            @$archive->extractCurrent($tmp);
            @$archive->next();
        }
        unlink($tmp . '.tgz');
        return realpath($tmp);
    }

}