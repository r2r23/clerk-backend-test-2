<?
class Phone
{
	const TABLE     = 'phones';
	const PERSISTED = ['id', 'contactId', 'phone'];

	public $id = 0;
	public $contactId;
	public $phone;

    public function setPhone(string $string)
    {
        if(preg_match('/\d{11}/', $string) === 1) $this->phone = $string;
        else throw new Exception("Error! 11 digits only please!");
    }

    public function setContactId(string $id)
    {
        $this->contactId = $id;        
    }

}
?>