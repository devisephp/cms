<?php namespace Devise\Menus;

use Devise\Support\Framework;

class MenusManager
{
    /**
     * Keeps up with model for DvsMenu
     *
     * @var \DvsMenu
     */
	protected $Menu;

    /**
     * Keeps up with model for DvsMenuItem
     *
     * @var \DvsMenuItem
     */
    protected $MenuItem;

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
     * Construct a new user manager
     *
     * @param \DvsMenu $Menu
     * @param \errors $MenuItem
     * @param Framework $Framework
     */
	public function __construct(\DvsMenu $Menu, \DvsMenuItem $MenuItem, Framework $Framework)
	{
		$this->Menu = $Menu;
		$this->MenuItem = $MenuItem;
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
        	'name' => 'required|unique:dvs_menus',
        	'language_id' => 'required',
		);
	}

	/**
	 * Creates a new menu
	 *
	 * @param  array $input
	 * @return Menu || null
	 */
	public function createMenu($input)
	{
        $validator = $this->Validator->make($input, $this->createRules());

        if ($validator->fails()){
            $this->message = 'Validation failure.';
            $this->errors = $validator->errors()->all();

            return false;
        } else {

            $this->message = 'Menu item created.';
    		$menu = $this->Menu;
            $menu->language_id = $input['language_id'];
    		$menu->name = $input['name'];
    		$menu->save();

    		return $menu;
        }
	}

	/**
	 * These are the update rules for a menu given an id
	 *
	 * @param  integer $id
	 * @return array
	 */
	public function updateRules($id)
	{
		return array(
			'name' => "required|unique:dvs_menus,name,{$id}",
            'item' => 'array',
            'item_order' => 'array',
		);
	}

    /**
     * Updates the active field of a Menu
     *
     * @param $id
     * @param  array $input
     * @return Menu || null
     */
	public function updateMenu($id, $input)
	{
        $validator = $this->Validator->make($input, $this->updateRules($id));

        if ($validator->fails())
        {
            $this->message = 'Validation failure.';
            $this->errors = $validator->errors()->all();

            return false;
        }

		$menu = $this->Menu->findOrFail($id);
		$menu->name = $input['name'];
		$menu->save();

		$this->syncMenuItems($menu, $input);

		return $menu;
	}

    /**
     * Sync the menu items with this menu, this
     * creates new items, reorders the positions
     * and updates parent item ids too.
     *
     * @param Menu $menu
     * @param $input
     * @return void
     */
	protected function syncMenuItems($menu, $input)
	{
		$position = 0;

		if (!isset($input['item']) )
		{
			$input['item'] = array();
		}

		if (!isset($input['item_order']))
		{
			$input['item_order'] = array();
		}

		list($items, $order) = $this->createNewMenuItems($menu, $input['item'], $input['item_order']);

		// sync up all the menu item data
		foreach ($items as $id => $item) {
			$menuItem = $this->MenuItem->findOrFail($id);

			if (isset($item['image'])) {
				$menuItem->image = $item['image'];
			}
			if (isset($item['url_or_page']) && $item['url_or_page'] !== 'page') {
				$item['page_id'] = NULL;
			}

			$menuItem->parent_item_id = $order[$id] ?: null;
			$menuItem->url = $item['url'];
			$menuItem->page_id = $item['page_id'];
			$menuItem->name = $item['name'];
			$menuItem->position = $position++;
			$menuItem->permission = array_get($item, 'permission', null);
			$menuItem->save();
		}

		// user removed these menu items so let's remove in database
		$removeItems = array_diff($menu->allItems()->lists('id'), array_keys($items));

		foreach ($removeItems as $removeItem) {
			$item = $this->MenuItem->find($removeItem);
			if ($item) $item->delete();
		}
	}

	/**
	 * Create any new menu items that don't exist yet
	 * and then inject them into our items array
	 * also we update the order array to include
	 * any new menu items that we just created
	 *
	 * @param Menu $menu
	 * @param array $items
	 * @param array $order
	 * @return array($items, $order)
	 */
	protected function createNewMenuItems($menu, $items, $order)
	{
		$newlyCreated = array();


		// create new items if there are any found
		foreach ($items as $id => $item)
		{
			if (!is_numeric($id))
			{
				if ($item['url_or_page'] == 'page' && (!isset($item['page_id']) || $item['page_id'] == '')) {
					unset($items[$id]);
					unset($order[$id]);
					continue;
				}

				if ($item['url_or_page'] == 'url') {
					$item['page_id'] = NULL;
				}

				$menuItem = $this->MenuItem->create([
					'menu_id' => $menu->id,
					'parent_item_id' => null,
					'page_id' => $item['page_id'],
					'url' => $item['url'],
					'image' => array_get($item, 'image', NULL),
					'name' => $item['name'],
					'position' => 0,
				]);

				unset($items[$id]);
				$items[$menuItem->id] = array(
					'url' => $menuItem->url,
					'name' => $menuItem->name,
					'page_id' => $menuItem->page_id
				);
				$newlyCreated[$id] = $menuItem->id;
			}
		}

		// replace all the order ids with newly created ids
		$newOrder = array();

		foreach ($order as $key => $value)
		{
			$id = array_key_exists($key, $newlyCreated) ? $newlyCreated[$key] : $key;
			$nestedId = array_key_exists($value, $newlyCreated) ? $newlyCreated[$value] : $value;
			$newOrder[$id] = $nestedId;
		}

		$newItems = array();

		// rearrange items to be in the correct order listed
		foreach ($newOrder as $id => $parentId)
		{
			$newItems[$id] = $items[$id];
		}

		return array($newItems, $newOrder);
	}
}