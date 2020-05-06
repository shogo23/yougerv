<?php namespace App\Assets;

use Config\Database;
use Config\Services;
use Carbon\Carbon;

class AssetsBase {
    
    //DB Property.
    protected $db;

    //Session Property.
    protected $session;

    public function __construct() {
        $this->db = Database::connect();
        $this->session = Services::session();
    }

    protected function _datetime() {
        return Carbon::now('Asia/Taipei');
    }

    protected function removeImage($path_filename) {
        if (file_exists($path_filename)) {
            if (unlink($path_filename)) {
                return true;
            }
        }
    }
}