<?php namespace Devise\Meta;

use Devise\Support\Framework;

class MetaManager
{
    /**
     * Keeps up with model for DvsMeta
     *
     * @var \DvsMeta
     */
	protected $Meta;

    /**
     * Keeps any errors from validation
     *
     * @var \errors
     */
    public $errors;

    /**
     * Generic message for success or failure of method execution
     *
     * @var \message
     */
    public $message;

    /**
     * Construct a new meta manager
     *
     * @param \DvsMeta $Meta
     * @param \errors $MetaItem
     * @param Framework $Framework
     */
	public function __construct(\DvsMeta $Meta, Framework $Framework)
	{
		$this->Meta = $Meta;
    $this->Validator = $Framework->Validator;
	}

	/**
	 * These are create rules for a menu
	 *
	 * @return array
	 */
	public function createRules()
	{
		return array(
    	'property' => 'required',
    	'value' => 'required',
    	'key' => 'required'
		);
	}

	/**
	 * Creates a new menu
	 *
	 * @param  array $input
	 * @return Meta || null
	 */
	public function createMeta($input)
	{
    $validator = $this->Validator->make($input['meta'], $this->createRules());

    if ($validator->fails()){
      $this->message = 'Validation failure.';
      return $validator->errors()->all();
    } else {
      $this->message = 'Meta item created.';

      $data = [
        'value' => $input['meta']['value'],
        'property' => $input['meta']['property'],
        'key' => $input['meta']['key']
      ];

      if ($input['pageId'] !== null) {
        $data['page_id'] = $input['pageId'];
      }

      return $this->Meta->create($data);
    }
	}

  /**
   * Creates a new menu
   *
   * @param  array $input
   * @return Meta || null
   */
  public function updateMeta($input)
  {
    $validator = $this->Validator->make($input['meta'], $this->createRules());

    if ($validator->fails()){
      $this->message = 'Validation failure.';
      return $validator->errors()->all();
    } else {
      $this->message = 'Meta item updated.';

      $meta = $this->Meta->findOrFail($input['meta']['id']);
      $meta->value = $input['meta']['value'];
      $meta->property = $input['meta']['property'];
      $meta->key = $input['meta']['key'];

      $meta->save();
      return $meta;
    }
  }

  /**
   * Delete Meta
   *
   * @param $id
   * @param  array $input
   * @return Meta || null
   */
   public function deleteMeta($id)
   {
     $meta = $this->Meta->findOrFail($id);
     $meta->delete();

     return 'OK';
   }
}
