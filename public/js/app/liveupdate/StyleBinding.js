devise.define([], function()
{
	/**
	 * one-way bindings for style attribute
	 */
	var StyleBinding = function(node, match, values, name, style, value)
	{
		this.node = node;
		this.match = match;
		this.values = values;
		this.name = name;
		this.style = style;
		this.value = value;
	}

	/**
	 * updates the styles for this node
	 */
	StyleBinding.prototype.apply = function()
	{
		var value = typeof this.values[this.name] === 'undefined' ? '' : this.values[this.name];

		var newValue = strReplace(this.match, value.toString(), this.value);

		if (!value)
		{
			this.node.style[this.style] = 'inherit';
		}
		else
		{
			this.node.style[this.style] = newValue;
		}
	}

	/**
	 * replace the old value with new value in the style
	 */
	function strReplace(needle, replacement, haystack)
	{
		if (!needle) return haystack;

		return haystack.replace(new RegExp(needle, 'g'), replacement);
	}

	return StyleBinding;
});