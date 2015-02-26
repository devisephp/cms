<?php namespace Devise\Pages\Interpreter;

/**
 * Class Block is a container class that
 * represents the tree hierarchy of html
 * from inside of the blade view. This could be
 * if/foreach blocks nested inside of other if/foreach
 * blocks. We do this so we can find the position of
 * devise tags that are not always rendered to the page
 * because they are nested under some block.
 *
 * @package Devise\Pages\Interpreter
 */
class Block
{
    /**
     * The type of block could be include or block
     * this helps us in the getTags() method so we
     * don't try to get children tags of include blocks
     * because those are separate views, and we don't
     * need those. They will be included in their own
     * view blade files with
     *
     *     App::make('DvsPageData')->addBinding(...)
     *     App::make('DvsPageData')->addCollection(...)
     *
     * and we could easily end up with duplicated tags
     * in both views if we didn't keep track of this
     *
     * @var string
     */
    public $type  = 'block';

    /**
     * Keeps track of views that we've included
     * this prevents us from re-opening other views
     * so we don't have recursive loops going on
     *
     * @var array
     */
    public $includedViews;

    /**
     * Starting node of block (in html)
     *
     * @var Node
     */
    protected $start;

    /**
     * Stopping node of block (in html)
     *
     * @var Node
     */
    protected $stop;

    /**
     * These are blocks that have been
     * nested inside of this block
     *
     * @var array
     */
    protected $childBlocks;

    /**
     * These are devise tags that are directly
     * under this block (only direct children)
     *
     * @var array
     */
    protected $tags;

    /**
     * These are devise models that are directly
     * under this block (only direct models)
     *
     * @var array
     */
    protected $models;

    /**
     * Construct a new block
     */
    public function __construct()
	{
		$this->childBlocks = [];
		$this->tags = [];
        $this->models = [];
        $this->modelCreators = [];
		$this->includedViews = [];
	}

    /**
     * Sets the starting node for this block
     *
     * @param Nodes\Node $node
     */
    public function start(Nodes\Node $node)
	{
		$this->type = $node->type;
		$this->start = $node;
	}

    /**
     * Sets the stopping node for this block. Some
     * block types don't have stopping nodes like the
     * @include block. An if and foreach will have stopping
     * blocks though (@endif and @endforeach) respectively
     *
     * @param Nodes\Node $node
     */
    public function stop(Nodes\Node $node)
	{
		$this->stop = $node;
	}

    /**
     * Add a devise tag to this block
     *
     * @param Nodes\Node $node
     */
    public function addTag(Nodes\Node $node)
	{
		$this->tags[] = new DeviseTag($node);
	}

    /**
     * Add a devise model to this block
     *
     * @param Nodes\Node $node
     */
    public function addModel(Nodes\Node $node)
    {
        $this->models[] = new DeviseModel($node);
    }

    /**
     * Add a devise model creator to this block
     *
     * @param Nodes\Node $node
     */
    public function addModelCreator(Nodes\Node $node)
    {
        $this->modelCreators[] = new DeviseModelCreator($node);
    }

    /**
     * Add another nested block to this block
     *
     * @param Block $block
     */
    public function addBlock(Block $block)
	{
		$this->childBlocks[] = $block;
	}

    /**
     * Gets the starting position of this block
     *
     * @return integer
     */
    public function getStartingPosition()
	{
		return $this->start->position;
	}

    /**
     * Gets the starting node for block
     *
     * @return Nodes\Node
     */
    public function getStartBlock()
	{
		return $this->start;
	}

    /**
     * Gets the stopping node for this block
     *
     * @return Nodes\Node
     */
    public function getStopBlock()
	{
		return $this->stop;
	}

    /**
     * All the children blocks of this
     * block
     *
     * @return array
     */
    public function getBlocks()
	{
		return $this->childBlocks;
	}

    /**
     * Get all tags for all children blocks
     * that have been nested. This is a helper
     * method that traverses through all tags
     * in this block and all it's nested block tags too
     *
     * @param array $includeTypes
     * @return array
     */
    public function getTags($includeTypes = ['block'])
	{
		$tags = $this->tags;

		foreach ($this->childBlocks as $childBlock)
		{
			if (in_array($childBlock->type, $includeTypes))
			{
				$tags = array_merge($tags, $childBlock->getTags());
			}
		}

		return $tags;
	}

    /**
     * Return an array of models for this Block
     *
     * @return array
     */
    public function getModels($includeTypes = ['block'])
    {
        $models = $this->models;

        foreach ($this->childBlocks as $childBlock)
        {
            if (in_array($childBlock->type, $includeTypes))
            {
                $models = array_merge($models, $childBlock->getModels());
            }
        }

        return $models;
    }

    /**
     * Returns an array of model creators for this Block
     *
     * @param  array $includeTypes
     * @return array
     */
    public function getModelCreators($includeTypes = ['block'])
    {
        $modelCreators = $this->modelCreators;

        foreach ($this->childBlocks as $childBlock)
        {
            if (in_array($childBlock->type, $includeTypes))
            {
                $modelCreators = array_merge($modelCreators, $childBlock->getModelCreators());
            }
        }

        return $modelCreators;
    }
}