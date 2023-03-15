<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Journals extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["journals"] = \Dao\Mnt\Journals::findAll();
        Renderer::render('mnt/journals', $viewData);
    }
}
?>
