<?php namespace Devise\Pages\Interrupter;

class DeviseBladeCompiler
{
	public function __construct(BlockFactory $BlockFactory)
	{
		$this->BlockFactory = $BlockFactory;
	}

	/**
	 * Compile a blade view for the data-devise html data bindings
	 *
	 * @param  string $view
	 * @return string
	 */
	public function compile($view)
	{
		// gets the block structure for this view
		$block = $this->BlockFactory->createBlock($view);

		// no tags found so don't touch $view
		if (count($block->getTags()) == 0)
		{
			return $view;
		}

		// loop through the blocks
		// for this block (exclude include type)
		// and put all tags found at the top
		// starting position inside the $view
		$view = $this->addHiddenPlaceHoldersToView($view, $block);

		// also need to replace the data devise tags
		// inside of our view with the data-dvs-...-id="stuff"
		$view = $this->replaceDataDeviseTags($view, $block);

		// adds bindings to top of the view page so we 
		// can do the javascript json stuff for dvsPageData
		$view = $this->addDeviseTagBindingsAndCollections($view, $block);

		// done changing up the view
		return $view;
	}

	/**
	 * [replaceDataDeviseTags description]
	 * @param  [type] $view  [description]
	 * @param  [type] $block [description]
	 * @return [type]        [description]
	 */
	protected function replaceDataDeviseTags($view, $block)
	{
		$tags = $block->getTags();

		foreach ($tags as $tag)
		{
			$view = $tag->replaceTagInView($view);
		}

		return $view;
	}

	/**
	 * [addDeviseTagBindingsAndCollections description]
	 * @param [type] $view  [description]
	 * @param [type] $block [description]
	 */
	public function addDeviseTagBindingsAndCollections($view, $block)
	{
		$tags = $block->getTags();

		if (count($tags) == 0) return $view;

		$prepend = "";

		foreach ($tags as $tag)
		{
			$prepend .= $tag->addToDevisePageStr();
		}

		return "<?php" . PHP_EOL . $prepend . "?>" . PHP_EOL . $view;
	}

	/**
	 * [addHiddenPlaceHoldersToView description]
	 * @param [type] $view  [description]
	 * @param [type] $block [description]
	 */
	protected function addHiddenPlaceHoldersToView($view, $block)
	{
		// when we start adding stuff to our
		// view then our positions all become
		// relative to the offset...
		$offset = 0;

		foreach ($block->getBlocks() as $child)
		{
			if ($child->type == 'block')
			{
				foreach ($child->getTags(['block', 'include']) as $tag)
				{
					$placeholder = $tag->hiddenPlaceholderStr();
					$position = $offset + $child->getStartingPosition();
					$offset += strlen($placeholder);
					$view = substr_replace($view, $placeholder, $position, 0);
				}
			}
		}

		return $view;
	}
}