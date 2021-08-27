<?
class PhonesController
{

    public static function store()
    {
        // model
        $Phone = new Phone;
        $Phone->setContactId($_POST['contactId']);
        $Phone->setPhone($_POST['phone']);

        $Contact = ORM::load('Contact', "where id = {$Phone->contactId}")[0];
        $Contact->updated = date("Y-m-d H:i:s");

        ORM::save($Phone);
        ORM::save($Contact);




        // view
        header("location:/clerk-test-phonebook");

    }
}
?>