<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use DateTime;
use Exception;
use Views\Renderer;

class User extends PublicController
{
    private $redirectTo = "index.php?page=Mnt-Users";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "usercod" => 0,
        "useremail" => "",
        "username" => "",
        "userpswd" => "",
        "userfching" => "",
        "userpswdest" => "",
        "userpswdexp" => "",
        "userest" => "",
        "useractcod" => "",
        "userpswdchg" => "",
        "usertipo" => "",

        "userest_ACT" => "selected",
        "userest_INA" => "",
        "usertipo_NOR" => "selected",
        "usertipo_CON" => "",
        "usertipo_CLI" => "",
        "userpswdest_ACT" => "selected",
        "userpswdest_INA" => "",

        "username_error" => "",
        "useremail_error" => "",
        "userpswd_error" => "",
        "general_errors" => array(),
        "has_errors" => false,
        "show_action" => true,
        "readonly" => false,
        "xssToken" => ""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar %s (%s)",
        "DEL" => "Borrar %s (%s)"
    );
    public function run(): void
    {
        try {
            $this->page_loaded();
            if ($this->isPostBack()) {
                $this->validatePostData();
                if (!$this->viewData["has_errors"]) {
                    $this->executeAction();
                }
            }
            $this->render();
        } catch (Exception $error) {
            unset($_SESSION["xssToken_Mnt_User"]);
            error_log(sprintf("Controller/Mnt/User ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                sprintf("Algo Inesperado Sucedió. Intente de Nuevo.". "Controller/Mnt/User ERROR: %s", $error->getMessage())
            );
        }
        /*
        1) Captura de Valores Iniciales QueryParams -> Parámetros de Query ? 
            https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029
        2) Determinamos el método POST GET
        3) Procesar la Entrada
            3.1) Si es un POST
            3.2) Capturar y Validara datos del formulario
            3.3) Según el modo realizar la acción solicitada
            3.4) Notificar Error si hay
            3.5) Redirigir a la Lista
            4.1) Si es un GET
            4.2) Obtener valores de la DB sin no es INS
            4.3) Mostrar Valores
        4) Renderizar
        */
    }
    private function page_loaded()
    {
        if (isset($_GET['mode'])) {
            if (isset($this->modes[$_GET['mode']])) {
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET['usercod'])) {
                $this->viewData["usercod"] = intval($_GET["usercod"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData()
    {
        if (isset($_POST["xssToken"])) {
            if (isset($_SESSION["xssToken_Mnt_User"])) {
                if ($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_User"]) {
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }

        //Values
        //USER COD
        if (isset($_POST["usercod"])) {
            if (($this->viewData["mode"] !== "INS" && intval($_POST["usercod"]) <= 0)) {
                throw new Exception("usercod is not Valid");
            }
            if ($this->viewData["usercod"] !== intval($_POST["usercod"])) {
                throw new Exception("usercod value is different from query");
            }
        } else {
            throw new Exception("usercod not present in form");
        }

        // USER NAME
        if (isset($_POST["username"])) {
            if (\Utilities\Validators::IsEmpty($_POST["username"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["username_error"] = "El Nombre de Usuario no puede ir vacío!";
            }
        } else {
            throw new Exception("username not present in form");
        }

        // USER PASSWORD
        if (isset($_POST["userpswd"])) {
            if (\Utilities\Validators::IsEmpty($_POST["userpswd"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["userpswd_error"] = "La contraseña no puede ir vacía!";
            }
        } else {
            throw new Exception("userpswd not present in form");
        }

        // USER EMAIL
        if (isset($_POST["useremail"])) {
            if (\Utilities\Validators::IsEmpty($_POST["useremail"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["useremail_error"] = "El email no puede ir vacío!";
            }
            // if (\Utilities\Validators::IsValidEmail($_POST["useremail"])) {
            //     $this->viewData["has_errors"] = true;
            //     $this->viewData["useremail_error"] = "El email no es válido";
            // }
        } else {
            throw new Exception("useremail not present in form");
        }

        // USER TIPO
        if (isset($_POST["usertipo"])) {
            if (!in_array($_POST["usertipo"], array("NOR", "CON", "CLI"))) {
                throw new Exception("usertipo incorrect value");
            }
        } else {
            if ($this->viewData["mode"] !== "DEL") {
                throw new Exception("usertipo not present in form");
            }
        }

        // USER STATUS
        if (isset($_POST["userest"])) {
            if (!in_array($_POST["userest"], array("ACT", "INA"))) {
                throw new Exception("userest incorrect value");
            }
        } else {
            if ($this->viewData["mode"] !== "DEL") {
                throw new Exception("userest not present in form");
            }
        }

        // USERPASSWORD STATUS
        if (isset($_POST["userpswdest"])) {
            if (!in_array($_POST["userpswdest"], array("ACT", "INA"))) {
                throw new Exception("userpswdest incorrect value");
            }
        } else {
            if ($this->viewData["mode"] !== "DEL") {
                throw new Exception("userpswdest not present in form");
            }
        }
        // VALUES 

        if (isset($_POST["mode"])) {
            if (!key_exists($_POST["mode"], $this->modes)) {
                throw new Exception("mode has a bad value");
            }
            if ($this->viewData["mode"] !== $_POST["mode"]) {
                throw new Exception("mode value is different from query");
            }
        } else {
            throw new Exception("mode not present in form");
        }

        $this->viewData["useremail"] = $_POST["useremail"];
        $this->viewData["username"] = $_POST["username"];
        $this->viewData["userpswd"] = $_POST["userpswd"];
        $this->viewData["useractcod"] = $_POST["useractcod"];
        $this->viewData["userpswdchg"] = $_POST["userpswdchg"];
        $this->viewData["userpswdexp"] = $_POST["userpswdexp"];

        if ($this->viewData["mode"] !== "DEL") {
            $this->viewData["usertipo"] = $_POST["usertipo"];
            $this->viewData["userest"] = $_POST["userest"];
            $this->viewData["userpswdest"] = $_POST["userpswdest"];
        }
    }
    private function executeAction()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $inserted = \Dao\Mnt\Users::insert(
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpswd"],
                    $this->viewData["userpswdest"],
                    $this->viewData["userpswdexp"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["userpswdchg"],
                    $this->viewData["usertipo"]
                );
                if ($inserted > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Creado Exitosamente"
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Users::update(
                    $this->viewData["useremail"],
                    $this->viewData["username"],
                    $this->viewData["userpswd"],
                    $this->viewData["userpswdest"],
                    $this->viewData["userpswdexp"],
                    $this->viewData["userest"],
                    $this->viewData["useractcod"],
                    $this->viewData["userpswdchg"],
                    $this->viewData["usertipo"],
                    $this->viewData["usercod"]
                );
                if ($updated > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Actualizado Exitosamente"
                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Users::delete(
                    $this->viewData["usercod"]
                );
                if ($deleted > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Usuario Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render()
    {
        $xssToken = md5("USUARIO" . rand(0, 4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_User"] = $xssToken;

        if ($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpUsuarios = \Dao\Mnt\Users::findById($this->viewData["usercod"]);
            if (!$tmpUsuarios) {
                throw new Exception("Usuario no existe en DB");
            }
            //$this->viewData["catnom"] = $tmpUsuarios["catnom"];
            //$this->viewData["catest"] = $tmpUsuarios["catest"];
            \Utilities\ArrUtils::mergeFullArrayTo($tmpUsuarios, $this->viewData);
            $this->viewData["userest_ACT"] = $this->viewData["userest"] === "ACT" ? "selected" : "";
            $this->viewData["userest_INA"] = $this->viewData["userest"] === "INA" ? "selected" : "";
            $this->viewData["usertipo_NOR"] = $this->viewData["usertipo"] === "NOR" ? "selected" : "";
            $this->viewData["usertipo_CON"] = $this->viewData["usertipo"] === "CON" ? "selected" : "";
            $this->viewData["usertipo_CLI"] = $this->viewData["usertipo"] === "CLI" ? "selected" : "";
            $this->viewData["userpswdest_ACT"] = $this->viewData["userpswdest"] === "ACT" ? "selected" : "";
            $this->viewData["userpswdest_INA"] = $this->viewData["userpswdest"] === "INA" ? "selected" : "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["username"],
                $this->viewData["usercod"]
            );
            if (in_array($this->viewData["mode"], array("DSP", "DEL"))) {
                $this->viewData["readonly"] = "readonly";
            }
            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
        }
        Renderer::render("mnt/user", $this->viewData);
    }
}
