devise.define([], function()
{
	/**
	 * one way bindings for attributes
	 */
	var AttributeBinding = function(node, key, lookup)
	{
		this.node = node;
		this.key = key;
		this.lookup = lookup;
	}

	/**
	 * updates values for this node
	 */
	AttributeBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);
		this.old = this.node.nodeValue;
		this.node.nodeValue = value;
	}

	return AttributeBinding;
})