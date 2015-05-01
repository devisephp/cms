<?php namespace Devise\Pages\Interpreter\Modifiers;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\InlineHTML;
use Devise\Pages\Interpreter\DeviseTag;
use Devise\Pages\Interpreter\DeviseParser;

class RegisterDeviseTags extends NodeVisitorAbstract
{
	/**
	 * Registrations are the tags that have been registered
	 * from this node's traversal
	 *
	 * @var array
	 */
	protected $registrations = [];

	/**
	 * Create a new RegisterDeviseTags visitor
	 *
	 * @param DeviseParser $DeviseParser
	 */
	public function __construct(DeviseParser $DeviseParser)
	{
		$this->DeviseParser = $DeviseParser;
	}

	/**
	 * We are examine this node for data-devise tags inside
	 * of the html. We only need to check out InlineHTML nodes
	 *
	 * @param  Node   $node
	 * @return void
	 */
	public function enterNode(Node $node)
	{
		if ($node instanceof InlineHTML)
		{
			$node->value = $this->parseNode($node->value);
		}

		return $node;
	}

	/**
	 * Runs after all the nodes have been examined
	 *
	 * @param  array  $nodes
	 * @return array
	 */
	public function afterTraverse(array $nodes)
	{
		$nodes = array_reverse($nodes);

		foreach ($this->registrations as $registration)
		{
			$register = $this->getAppMakeRegisterString($registration);

			$stmts = $this->DeviseParser->parse($register);

			foreach ($stmts as $stmt)
			{
				$nodes[] = $stmt;
			}
		}

		$nodes[] = $this->addDvsPageDataInitializeStmt();

		return array_reverse($nodes);
	}

	/**
	 * [addDvsPageDataInitializeStmt description]
	 */
	protected function addDvsPageDataInitializeStmt()
	{
		$init = '<?php App::make(\'dvsPageData\')->initialize($page->id, $page->version->id, $page->language_id, csrf_token()); ?>';

		$initStmt = $this->DeviseParser->parse($init);

		return $initStmt[0];
	}

	/**
	 * Parses the node of html for us
	 *
	 * @param  string $html
	 * @return string
	 */
	protected function parseNode($html)
	{
		$tags = $this->DeviseParser->getDeviseTags($html);

		foreach ($tags as $tag)
		{
			$html = $this->registerDeviseTag($tag, $html);
		}

		return $html;
	}

	/**
	 * Register a devise tag, and also replaces the data-devise
	 * html with the cid stuff
	 *
	 * @return string
	 */
	protected function registerDeviseTag(DeviseTag $tag, $html)
	{
		$this->registrations[] = $tag;

		$newTag = $this->getNewDeviseTagString($tag);

		return str_replace($tag, $newTag, $html);
	}

	/**
	 * Creates a string of App::make register statements for us
	 *
	 * @param  DeviseTag $tag
	 * @return string
	 */
	protected function getAppMakeRegisterString(DeviseTag $tag)
	{
		list($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults) = $tag->toArray("'");

		$register = $bindingType === "'variable'"
			? "<?php App::make('dvsPageData')->register('{$id}', {$bindingType}, {$collection}, '{$id}', {$type}, {$humanName}, {$collectionName}, {$group}, {$category}, {$alternateTarget}); ?>"
			: "<?php App::make('dvsPageData')->register('{$id}', {$bindingType}, {$collection}, {$key}, {$type}, {$humanName}, {$collectionName}, {$group}, {$category}, {$alternateTarget}); ?>";

		$register = "<?php try { App::make('dvsPageData')->setDefaults('{$id}', {$defaults}); } catch (Exception \$e) {} ?>" . $register;

		return $register;
	}

	/**
	 * Creates a string from tag parameters which will be used
	 * to rewrite the data-devise html
	 *
	 * @param  DeviseTag $tag
	 * @return string
	 */
	protected function getNewDeviseTagString(DeviseTag $tag)
	{
		list($id, $bindingType, $collection, $key, $type, $humanName, $collectionName, $group, $category, $alternateTarget, $defaults, $chain) = $tag->toArray('"');

		if ($bindingType === '"variable"')
		{
			$key = $chain;
		}

		return " data-devise-<?php echo devise_tag_cid('{$id}', {$bindingType}, {$collection}, {$key}, {$type}, {$humanName}, {$collectionName}, {$group}, {$category}, {$alternateTarget}, $defaults) ?>=\"{$id}\"";
	}
}