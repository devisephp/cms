<?php namespace Devise\Pages\Fields;

class FieldsRepositoryTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->FieldsRepository = new FieldsRepository(new \DvsField, new \DvsGlobalField);
	}

	public function test_it_finds_fields_by_key_and_page_version()
	{
		$output = $this->FieldsRepository->findFieldByKeyAndPageVersion('hello', 1, null);

		assertEquals(1, $output->id);
	}

	public function test_it_finds_trashed_fields_by_key_and_page_version()
	{
		\DvsField::find(1)->delete();

		$output = $this->FieldsRepository->findTrashedFieldByKeyAndPageVersion('hello', 1);

		assertEquals(1, $output->id);
	}

	public function test_it_finds_trashed_global_fields_by_key_and_language()
	{
		\DvsGlobalField::find(1)->delete();

		$output = $this->FieldsRepository->findTrashedGlobalFieldByKeyAndLanguage('key1', 45);

		assertEquals(1, $output->id);
	}

	public function test_it_finds_field_by_id()
	{
		$output = $this->FieldsRepository->findFieldById(1);

		assertEquals(1, $output->id);
	}

	public function test_it_finds_field_by_id_and_scope()
	{
		$output = $this->FieldsRepository->findFieldByIdAndScope(1, 'page');

		assertEquals(1, $output->id);
	}

	public function test_it_finds_trashed_field_by_id_and_scope()
	{
		\DvsField::find(1)->delete();

		$output = $this->FieldsRepository->findTrashedFieldByIdAndScope(1, 'page');

		assertEquals(1, $output->id);
	}

	public function test_it_finds_fields_by_global_key_and_language()
	{
		$output = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage('key1', 45);

		assertEquals(1, $output->id);
	}
}