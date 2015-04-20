devise.define([], function()
{
	/**
	 * one-way bindings for style attribute
	 */
	var StyleBinding = function(node, key, lookup, match, style, value)
	{
		this.node = node;
		this.key = key;
		this.match = match;
		this.lookup = lookup;
		this.style = style;
		this.value = value;
	}

	/**
	 * updates the styles for this node
	 */
	StyleBinding.prototype.apply = function()
	{
		var value = this.lookup(this.key);

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