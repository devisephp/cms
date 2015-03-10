<?php return [

	/*
	|--------------------------------------------------------------------------
	| DvsUser
	|--------------------------------------------------------------------------
	|
	| This configuration is used to map attributes of the DvsUser Eloquent
	| model to fields in devise. This allows us to change the model attributes
	| using our front end editor in devise. This is also used in e2e testing
	| for testing purposes. It is okay to remove this mapping in your
	| application though.
	|
	*/

	'DvsUser' =>
	[
		'rules' =>
		[
			'name' => 'required',
			'email' => 'email|required',
			'password' => 'required',
		],

		'picks' =>
		[
			'Name' => ['name' => 'text'],
			'Email' => ['email' => 'text'],
			'Password' => ['password' => 'text'],
		],

		'types' =>
		[
			'Name' => 'text',
			'Email' => 'text',
			'Password' => 'text',
		],
	],



	/*
	|--------------------------------------------------------------------------
	| DvsTestModel
	|--------------------------------------------------------------------------
	|
	| This configuration is used to map attributes of the DvsTestModel Eloquent
	| model to fields in devise. This allows us to change the model attributes
	| using our front end editor in devise. This is also used in e2e testing
	| for testing purposes. It is okay to remove this mapping in your
	| application though.
	|
	*/

	'DvsTestModel' =>
	[
		'rules' =>
		[
			'page_version_id' => 'required',
			'name' => 'required',
		],

		'picks' =>
		[
			'Name' => [ 'name' => 'text' ],
		],

		'types' =>
		[
			'Name' => 'text',
		]
	],
];