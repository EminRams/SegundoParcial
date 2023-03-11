<?php
    namespace Controllers\NW202301;

    use Controllers\PublicController;
    use Views\Renderer;

    class MiFicha extends PublicController{
        /* index.php?page=NW202301-MiFicha */
        public function run() :void
        {
            $viewData = array(
            "nombre" => "Emin Y Ramos",
            "email" => "eminramos@gmail.com",
            "title" => "Software Engenier"
            );

            Renderer::render("nw202301/miFicha", $viewData);
        }
    }
?>