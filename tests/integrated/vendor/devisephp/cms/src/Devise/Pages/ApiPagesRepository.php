<?php namespace Devise\Pages;

/**
 * Class ApiPagesRepository is used to retrieve DvsPage models of Function type
 *
 * @package Devise\Pages
 */
class ApiPagesRepository
{
    /**
     * Instance of the Page Model
     *
     * @var Page
     */
	private $Page;

    /**
     * Create a new ApiPagesRepository instance.
     *
     * @param \DvsPage $Page
     */
	public function __construct(\DvsPage $Page)
	{
		$this->Page = $Page;
	}

    /**
     * finds a record by it's id
     *
     * @param  int $id
     * @return Page
     */
	public function find($id)
	{
        return $this->Page->with('versions')->findOrFail($id);
	}

    /**
     * Finds all 'Funciton' type pages
     *
     * @return Paginator
     */
    public function pages()
    {
        return $this->Page
                    ->where('response_type', 'Function')
                    ->orderBy('dvs_admin','asc')
                    ->paginate();
    }
}