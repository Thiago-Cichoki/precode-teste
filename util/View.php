<?php

namespace util;

use util\Util;

class View
{
    const paths = [
        "login" => "../auth/views/login.php",
        "novoPerfilPolitico" => "../api/novoPerfilPolitico.php",
        "forgotPassword" => "../auth/views/forgot-password.php",
        "sign_up" => "../auth/views/sign_up.php",
        "completeRegistration" => "../auth/views/complete-registration.php",
        "header" => "../auth/views/header.php",
        "footer" => "../auth/views/footer.php",
    ];


    static function render($templateName, $data = []) {
        if (is_null(self::paths[$templateName])) { throw new \Exception("RENDERTEMPLATE_ERROR_PARAMSNOTFOUND"); }
        if (!file_exists(self::paths[$templateName])) { throw new \Exception("RENDERTEMPLATE_ERROR_FILENOTFOUND"); }

        $userLang = View::getLang();

        $data["pathSite"] = Util::getPathSite();

        ob_start();
        include(self::paths[$templateName]);
        $ret = ob_get_contents();
        ob_end_clean();
        print $ret;

    }

    static function getLang(){

        $defaultLang = "ptbr";
        $supportedLangs = ["en", "ptbr"];

        $inputLang = isset($_GET["lang"]) ? htmlspecialchars($_GET["lang"]) : null;
        return $inputLang && in_array($inputLang, $supportedLangs) ? $inputLang : $defaultLang;

    }

}
