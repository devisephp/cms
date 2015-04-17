devise.define([], function()
{
	/**
	 * one-way bindings for class attribute
	 */
	var ClassBinding = function(node, match, values, name)
	{
		this.node = node;
		this.match = match;
		this.old = this.match;
		this.oldValues = [this.match];
		this.values = values;
		this.name = name;
	}

	/**
	 * updates values for this node
	 */
	ClassBinding.prototype.apply = function()
	{
		var value = typeof this.values[this.name] === 'undefined' ? '' : this.values[this.name];

		value = value.replace(new RegExp(',', 'g'), '');

		if (value === '') value = this.match;
		if (value === this.old) return;

		var values = value.split(' ');

		for (var i = 0; i < this.oldValues.length; i++)
		{
			this.oldValues[i] && this.node.classList.remove(this.oldValues[i]);
		}

		for (var i = 0; i < values.length; i++)
		{
			values[i] && this.node.classList.add(values[i]);
		}

		this.old = value;
		this.oldValues = values;
	}

	return ClassBinding;
})