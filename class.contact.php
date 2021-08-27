<?
class Contact
{
	const TABLE     = 'contacts';
	const PERSISTED = ['id', 'surname', 'name', 'fname', 'updated'];

	public $id = 0;
	public $surname;
	public $name;
	public $fname;
	public $updated;

    public $phones = [];
	

}
?>