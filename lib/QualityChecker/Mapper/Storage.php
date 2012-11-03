<?php

namespace QualityChecker\Mapper;

class Storage {
    protected $mongo;
    protected $db;
    
    public function __construct() {
        $this->mongo = new \Mongo;
        $this->db = $this->mongo->selectDB("quality");
    }

    public function store($data) {
        $row = $this->db->repos->findOne(array('url' => $data['url']));
        if ($row) {
            $this->db->repos->remove($row);
        }
        $this->db->repos->insert($data);
    }

}