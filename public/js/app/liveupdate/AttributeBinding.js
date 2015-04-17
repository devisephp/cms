devise.define([], function()
{
	/**
	 * one way bindings for attributes
	 */
	var AttributeBinding = function(attribute, match, values, name)
	{
		this.node = attribute;
		this.match = match;
		this.values = values;
		this.name = name;
	}

	/**
	 * updates values for this node
	 */
	AttributeBinding.prototype.apply = function()
	{
		var value = typeof this.values[this.name] === 'undefined' ? '' : this.values[this.name];
		this.old = this.node.nodeValue;
		this.node.nodeValue = value;
	}

	return AttributeBinding;
})