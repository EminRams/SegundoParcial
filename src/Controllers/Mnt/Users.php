<?php
namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;

class Users extends PublicController {
    public function run() :void
    {
        $viewData = array(
            "edit_enabled"=>true,
            "delete_enabled"=>true,
            "new_enabled"=>true
        );
        $viewData["users"] = \Dao\Mnt\Users::findAll();
        Renderer::render('mnt/users', $viewData);
    }
}
?>
