<?php namespace Devise\Pages\Repositories;

use Devise\Pages\Helpers\Strings;
use Field;

class FieldsRepository extends BaseRepository {
	/**
	 * Instance of the Field Model
	 *
	 * @var Field
	 */
	private $Field;


	/**
	 * Create a new TemplatesRepository instance.
	 *
     * @param  Field  $Field
	 */
	public function __construct(Field $Field)
	{
		$this->Field = $Field;
	}

    /**
     * saves a new field
     *
     * @param string $field
     * @return void
     */
	public function saveNew($field)
	{
        $fieldData = array(
            'template' => $field['template'],
            'human_name' => $field['name'],
            'key' => Strings::fromHuman($field['name']),
            'type' => $field['field-type']
        );
        $this->Field->create($fieldData);
    }

    /**
     * updates an existing field record
     *
     * @param string $field
     * @return void
     */
    public function updateExisting($id, $field)
    {
        $field = $this->Field->findOrFail($id);
        $field->template = $field['template'];
        $field->human_name = $field['name'];
        $field->key = $field['name'];
        $field->type = $field['field-type'];
        $field->update();
    }


    /**
     * retrieves a field by it's name where the template path matches given or template is blank (global)
     *
     * @param string $path
     * @param string $name
     * @return object
     */
    public function retrieveForScanner($path, $name)
    {
        return $this->Field->whereIn('template',array('', $path))
                           ->whereKey($name)
                           ->first();
    }
}