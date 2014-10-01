<?php namespace Devise\Pages\Repositories;

use Validator;

class BaseRepository {
	/**
	 * The Validator instac
	 *
	 * @var Validator
	 */
	public $validator;

	/**
	 * Any validation or error message
	 *
	 * @var Array
	 */
	public $message;

	/**
	 * Any array of error message
	 *
	 * @var Array
	 */
	public $errors;

	/**
	 * Accepts a model instance, input data, validates and saves a new record
	 *
	 * @param  Eloquent  $model
	 * @param array $input
	 * @return false | ParticipanLocation
	*/
	public function simpleStore($model, $input)
	{
		$this->validator = Validator::make($input, $model->createRules, $model->messages);

		if ($this->validator->passes()){
			return $model->create($input);
		} else {
			$this->errors = $this->validator->errors()->all();
			$this->message = "There were validation errors.";
			return false;
		}
	}

	/**
	 * Validates input data and updates a record
	 * will return false or an instance of the model
	 *
	 * @param  Eloquent  $model
	 * @param  int  $id
	 * @param  array  $input
	 * @return false | Instance Of $model
	*/
	public function simpleUpdate($model, $id, $input)
	{
		$this->validator = Validator::make($input, $model->updateRules, $model->messages);

		if ($this->validator->passes()){
			$modelObject = $model->findOrFail($id);
			$modelObject->update($input);
			return $modelObject;
		} else {
			$this->errors = $this->validator->errors()->all();
			$this->message = "There were validation errors.";
			return false;
		}
	}
}
