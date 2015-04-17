devise.define(['jquery'], function($)
{
	/**
	 * one-way bindings for text nodes
	 */
	var TextBinding = function(node, match, values, name)
	{
		this.match = match;
		this.values = values;
		this.name = name;
		this.old = match;
		this.nodes = [node];
	}

	/**
	 * updates the nodes' to have correct value
	 */
	TextBinding.prototype.apply = function()
	{
		var value = typeof this.values[this.name] === 'undefined' ? '' : this.values[this.name];

		if (this.old === value) return;
		if (!this.parentNode) this.parentNode = this.nodes[0].parentNode;

		var firstNode = this.nodes[0];
		var nodes = createNodesFromHtml(value);

		for (var i = 0; i < nodes.length; i++)
		{
			this.parentNode.insertBefore(nodes[i], firstNode);
		}

		for (var i = 0; i < this.nodes.length; i++)
		{
			this.parentNode.removeChild(this.nodes[i]);
		}

		this.old = value;
		this.nodes = nodes;
	}

	/**
	 * creates nodes for this html value
	 */
	function createNodesFromHtml(value)
	{
		if (!value || value === '') return [ document.createTextNode('') ];

		var nodes = [];

		var childNodes = [];

		var el = $('<div/>');

		el.html(value);

		childNodes = el[0].childNodes;

		for (var i = 0; i < childNodes.length; i++)
		{
			nodes.push(childNodes[i].cloneNode(true));
		}

		return nodes;
	}

	return TextBinding;
})