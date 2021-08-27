<?
error_reporting(E_ALL);



// AUTO LOAD CLASSES
spl_autoload_register('mvcAutoLoad3');
function mvcAutoLoad3($className)
{
    require_once("class.".strtolower($className).".php");
}



// ROUTING
$uri=$_SERVER['REQUEST_URI'];
if($uri!='/' and substr($uri, -1)=='/') $uri=substr($uri, 0, -1); // remove end slash, if any, for not "/" route

    if($uri      == "/clerk-test-phonebook")                                           ContactsController::index(0);
elseif($uri      == "/clerk-test-phonebook/api")                                       ContactsController::index(1);
elseif(preg_match("|^/clerk-test-phonebook/contacts/destroy/(\d+)$|", $uri, $out)===1) ContactsController::destroy($out[1]);
elseif($uri      == "/clerk-test-phonebook/contacts/store")                            ContactsController::store();

elseif($uri      == "/clerk-test-phonebook/phones/store")                              PhonesController::store();

else echo '404 route';


?>
