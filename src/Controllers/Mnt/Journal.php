<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use DateTime;
use Exception;
use Twig\Node\ModuleNode;
use Views\Renderer;

class Journal extends PublicController
{
    private $redirectTo = "index.php?page=Mnt-Journals";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "journal_id" => 0,
        "journal_date" => "",
        "journal_type" => "",
        "journal_description" => "",
        "journal_amount" => 0,
        "created_at" => "",

        "journal_type_DEB" => "selected",
        "journal_type_CRE" => "",

        "journal_description_error" => "",
        "journal_date_error" => "",
        "journal_amount_error" => "",
        "general_errors" => array(),
        "has_errors" => false,
        "show_action" => true,
        "readonly" => false,
        "created_readonly" => false,
        "xssToken" => ""
    );
    private $modes = array(
        "DSP" => "Detalle de %s (%s)",
        "INS" => "Nuevo Diario",
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
            unset($_SESSION["xssToken_Mnt_Journal"]);
            error_log(sprintf("Controller/Mnt/Journal ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }
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
            if (isset($_GET['journal_id'])) {
                $this->viewData["journal_id"] = intval($_GET["journal_id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    private function validatePostData()
    {
        if (isset($_POST["xssToken"])) {
            if (isset($_SESSION["xssToken_Mnt_Journal"])) {
                if ($_POST["xssToken"] !== $_SESSION["xssToken_Mnt_Journal"]) {
                    throw new Exception("Invalid Xss Token no match");
                }
            } else {
                throw new Exception("Invalid Xss Token on Session");
            }
        } else {
            throw new Exception("Invalid Xss Token");
        }

        //Values
        //JOURNAL ID
        if (isset($_POST["journal_id"])) {
            if (($this->viewData["mode"] !== "INS" && intval($_POST["journal_id"]) <= 0)) {
                throw new Exception("journal_id is not Valid");
            }
            if ($this->viewData["journal_id"] !== intval($_POST["journal_id"])) {
                throw new Exception("journal_id value is different from query");
            }
        } else {
            throw new Exception("journal_id not present in form");
        }

        // JOURNAL DESCRIPTION
        if (isset($_POST["journal_description"])) {
            if (\Utilities\Validators::IsEmpty($_POST["journal_description"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["journal_description_error"] = "La descripción no puede ir vacío!";
            }
        } else {
            throw new Exception("journal_description not present in form");
        }

        // JOURNAL DATE
        if (isset($_POST["journal_date"])) {
            if (\Utilities\Validators::IsEmpty($_POST["journal_date"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["journal_date_error"] = "La fecha no puede ir vacía!";
            }
        } else {
            throw new Exception("journal_date not present in form");
        }




        // JOURNAL AMOUNT
        if (isset($_POST["journal_amount"])) {
            if (($this->viewData["mode"] !== "INS" && floatval($_POST["journal_amount"]) <= 0)) {
                throw new Exception("journal_amount is not Valid");
            }
            if (\Utilities\Validators::IsEmpty($_POST["journal_amount"])) {
                $this->viewData["has_errors"] = true;
                $this->viewData["journal_amount_error"] = "El monto no puede ir vacío!";
            }
            if (floatval($_POST["journal_amount"] <= 0)) {
                $this->viewData["has_errors"] = true;
                $this->viewData["journal_amount_error"] = "El monto debe ser mayor a Cero";
            }
        } else {
            throw new Exception("journal_amount not present in form");
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

        $this->viewData["journal_date"] = $_POST["journal_date"];
        $this->viewData["journal_description"] = $_POST["journal_description"];
        $this->viewData["journal_amount"] = $_POST["journal_amount"];
        $this->viewData["created_at"] = $_POST["created_at"];


        if ($this->viewData["mode"] !== "DEL") {
            $this->viewData["journal_type"] = $_POST["journal_type"];
        }
    }
    private function executeAction()
    {
        switch ($this->viewData["mode"]) {
            case "INS":
                $inserted = \Dao\Mnt\Journals::insert(
                    $this->viewData["journal_date"],
                    $this->viewData["journal_type"],
                    $this->viewData["journal_description"],
                    $this->viewData["journal_amount"],
                    $this->viewData["created_at"],
                );
                if ($inserted > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Diario Creado Exitosamente "
                    );
                }
                break;
            case "UPD":
                $updated = \Dao\Mnt\Journals::update(
                    $this->viewData["journal_date"],
                    $this->viewData["journal_type"],
                    $this->viewData["journal_description"],
                    $this->viewData["journal_amount"],
                    $this->viewData["journal_id"],
                );
                if ($updated > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Diario Actualizado Exitosamente" 

                    );
                }
                break;
            case "DEL":
                $deleted = \Dao\Mnt\Journals::delete(
                    $this->viewData["journal_id"]
                );
                if ($deleted > 0) {
                    \Utilities\Site::redirectToWithMsg(
                        $this->redirectTo,
                        "Diario Eliminado Exitosamente"
                    );
                }
                break;
        }
    }
    private function render()
    {
        $xssToken = md5("JOURNAL" . rand(0, 4000) * rand(5000, 9999));
        $this->viewData["xssToken"] = $xssToken;
        $_SESSION["xssToken_Mnt_Journal"] = $xssToken;

        if ($this->viewData["mode"] === "INS") {
            $this->viewData["modedsc"] = $this->modes["INS"];
        } else {
            $tmpJournals = \Dao\Mnt\Journals::findById($this->viewData["journal_id"]);
            if (!$tmpJournals) {
                throw new Exception("Cliente no existe en DB");
            }
            \Utilities\ArrUtils::mergeFullArrayTo($tmpJournals, $this->viewData);
            $this->viewData["journal_type_DEB"] = $this->viewData["journal_type"] === "1" ? "selected" : "";
            $this->viewData["journal_type_CRE"] = $this->viewData["journal_type"] === "2" ? "selected" : "";
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],
                $this->viewData["journal_date"],
                $this->viewData["journal_id"]
            );
            if (in_array($this->viewData["mode"], array("DSP", "DEL"))) {
                $this->viewData["readonly"] = "readonly";
            }
            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;
            }
            if(in_array($this->viewData["mode"], array("DSP", "UPD"))) {
                $this->viewData["created_readonly"] = "readonly";
            }
        }
        Renderer::render("mnt/journal", $this->viewData);
    }
}
