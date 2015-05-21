devise.define(['AttributeBinding', 'ClassBinding', 'StyleBinding', 'TextBinding'], function(AttributeBinding, ClassBinding, StyleBinding, TextBinding)
{
	/**
	 * default lookup
	 */
	var defaultLookup = function(key, database)
	{
		if (typeof database[key] === 'undefined') return '';

		return database[key];
	}

	/**
	 * default database setter
	 */
	var defaultSetter = function(key, value, database)
	{
		database[key] = value;
	}

	/**
	 * Bindings finder finds one way bindings
	 * inside of the DOM
	 */
	var BindingsFinder = function(models, lookup, setter)
	{
		lookup = typeof lookup !== 'function' ? defaultLookup : lookup;
		setter = typeof setter !== 'function' ? defaultSetter : setter;

		this.pattern = new RegExp('###dvsmagic-[^###]+###', 'g');
		this.models = models;
		this.lookup = function(key) { return lookup(key, models); }
		this.setter = function(key, value) { if (key) return setter(key, value, models); }
	}

	/**
	 * finds a list of bindings inside of this node,
	 * recursive in nature. Ideally we can just
	 * pass this the html node (document.childNodes[0])
	 * and it will get all the one-way bindings for us
	 */
	BindingsFinder.prototype.find = function(node)
	{
		var bindings = [];

		bindings = wrapApplyOnBindings(bindings);

		bindings.get = this.lookup;

		bindings.set = this.setter;

		bindings = recursivelyFindAllBindingsInsideOfNode(node, bindings, this);

		return bindings;
	}

	/**
	 * Finds all the bindings from this node and child nodes
	 */
	function recursivelyFindAllBindingsInsideOfNode(node, bindings, finder)
	{
		bindings = findElementBindings(node, bindings, finder);

		bindings = findTextBindings(node, bindings, finder);

		for (var i = 0; i < node.childNodes.length; i++)
		{
		   bindings = recursivelyFindAllBindingsInsideOfNode(node.childNodes[i], bindings, finder);
		}

		return bindings;
	}

	/**
	 * wraps the apply method on the entire array
	 * of bindings
	 */
	function wrapApplyOnBindings(bindings)
	{
		bindings.apply = function(key)
		{
			for (var index in bindings)
			{
				if (index !== 'apply' && typeof bindings[index].apply === 'function')
				{
					if (key) bindings[index].key === key && bindings[index].apply();
					else bindings[index].apply();
				}
			}
		}

		return bindings;
	}
	/**
	 * finds a property from a matched string
	 */
	function findPropertyFromMatch(match)
	{
		var split = match.substring(3, match.length-3).split('-');
		return split[3];
	}

	/**
	 * finds the key from this match
	 */
	function findKeyFromMatch(match)
	{
		var split = match.substring(3, match.length-3).split('-');
		var dvsmagic = split.shift();
		return split.join('-');
	}

	/**
	 * find all the attribute bindings
	 */
	function findElementBindings(node, bindings, finder)
	{
		if (node.nodeType !== node.ELEMENT_NODE || node.__magicAlreadyDone) return bindings;

		for (var i = 0; i < node.attributes.length; i++)
		{
			var attribute = node.attributes[i];
			var matches = attribute.nodeValue.match(finder.pattern);
			var numberOfMatches = matches && matches.length || 0;

			for (var j = 0; j < numberOfMatches; j++)
			{
				var key = findKeyFromMatch(matches[j]);

				if (attribute.name === 'style')
				{
					bindings = findStyleBindings(node, bindings, matches[j], finder.lookup);
				}
				else if (attribute.name === 'class')
				{
					bindings.push(new ClassBinding(node, key, finder.lookup, matches[j]));
				}
				else
				{
					bindings.push(new AttributeBinding(attribute, key, finder.lookup));
				}
			}
		}

		return bindings;
	}

	/**
	 * finds all the text one way bindings
	 */
	function findTextBindings(node, bindings, finder)
	{
		if (node.nodeType !== node.TEXT_NODE || node.__magicAlreadyDone) return bindings;

		var matches = node.nodeValue.match(finder.pattern);

		var numberOfMatches = matches && matches.length || 0;

		if (numberOfMatches === 0) return bindings;

		var segments = createSegmentedText(node, matches);

		for (var i = 0; i < segments.length; i++)
		{
			var newNode = document.createTextNode(segments[i]);
			var index = matches.indexOf(segments[i]);

			if (index > -1)
			{
				var key = findKeyFromMatch(matches[index]);
				bindings.push(new TextBinding(newNode, key, finder.lookup, matches[index]));
			}

			newNode.__magicAlreadyDone = true;
			node.parentNode.insertBefore(newNode, node);
		}

		node.parentNode.removeChild(node);

		return bindings;
	}

	/**
	 * we can have multiple ###dvsmagic### matches found
	 * inside of this text node, we need to segment them
	 * out...
	 */
	function createSegmentedText(textNode, matches)
	{
		var value = textNode.nodeValue;
		var segments = [ value ];

		for (var i = 0; i < matches.length; i++)
		{
			segments = segmentStringsByMatch(segments, matches[i]);
		}

		return segments;
	}

	/**
	 * Segments out the array of strings, separating
	 * them into the smallest text possible. This means
	 * that we should have some index such that
	 * segments[index] === match
	 */
	function segmentStringsByMatch(segments, match)
	{
		var newValues = [];

		for (var i = 0; i < segments.length; i++)
		{
			var value = segments[i];
			var pos = value.indexOf(match);
			var len = match.length;
			var beforeText = value.substr(0, pos);
			var afterText = value.substr(pos + len);

			if (pos === -1)
			{
				newValues.push(value);
				continue;
			}

			if (beforeText.length !== 0) newValues.push(beforeText);

			newValues.push(match);

			if (afterText.length !== 0) newValues.push(afterText);
		}

		return newValues;
	}

	/**
	 * finds all the style bings for all the matches
	 */
	function findStyleBindings(node, bindings, match, lookup)
	{
		var styles = node.attributes.getNamedItem('style').nodeValue.split(';');
		var affected = findAffectedStyles(styles, match);
		var key = findKeyFromMatch(match);

		for (var i = 0; i < affected.length; i++)
		{
			bindings.push(new StyleBinding(node, key, lookup, match, affected[i].style, affected[i].value));
		}

		return bindings;
	}

	/**
	 * find the styles that we need to update
	 */
	function findAffectedStyles(styles, match)
	{
		var affected = [];

		for (var i = 0; i < styles.length; i++)
		{
			var style = styles[i];
			var parts = style.split(':');
			var styleName = typeof parts[0] === 'undefined' ? null : parts[0];
			var styleValue = typeof parts[1] === 'undefined' ? null : parts[1];

			if (!styleValue || !styleName) continue;

			if (styleValue.indexOf(match) !== -1)
			{
				affected.push({
					style: toCamelCase(styleName.trim()),
					value: styleValue.trim()
				});
			}
		}

		return affected;
	}

	/**
	 * renames a str
	 */
	function toCamelCase(str)
	{
		var split = str.split('-');

		for (var i = split.length - 1; i > 0; i--)
		{
			split[i] = split[i].substr(0, 1).toUpperCase() + split[i].substr(1);
		}

		return split.join('');
	}

	return BindingsFinder;
})