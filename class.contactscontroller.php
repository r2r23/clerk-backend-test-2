<?
class ContactsController
{

    public static function index($json)
    {
        // model
        $contacts = ORM::load('Contact', "");
        foreach($contacts as $Contact)
        {
            $Contact->phones = ORM::load('Phone', "where contactId = {$Contact->id} order by id asc");
        }


        // view
        if($json == 1)
        {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(200);
            echo json_encode($contacts);
        }
        else
        {
            require_once("view-htmlheadbody.php");
            require_once("view-contacts.php");
            require_once("view-bodyhtml.php");
        }

    }



    public static function store()
    {
        // model
        $Contact = new Contact;
        $Contact->surname = $_POST['surname'];
        $Contact->name    = $_POST['name'];
        $Contact->fname   = $_POST['fname'];
        $Contact->updated = date("Y-m-d H:i:s");

        ORM::save($Contact);



        // view
        header("location:/clerk-test-phonebook");

    }









    public static function destroy($id)
    {
        // model
        ORM::delete('Contact', $id);

        // view
        header("location:/clerk-test-phonebook")
;    }





}
?>