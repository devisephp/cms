devise.define(['jquery', 'query'], function($, query)
{
	/**
	 * a giant list of possible styles we can change
	 */
	var possibleStyles = [
		'padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'border-top-left-radius', 'border-top-right-radius',
		'border-bottom-right-radius', 'border-bottom-left-radius', 'background-color', 'alignContent', 'alignItems', 'alignSelf',
		'alignmentBaseline', 'all', 'backfaceVisibility', 'background', 'backgroundAttachment', 'backgroundBlendMode', 'backgroundClip',
		'backgroundColor', 'backgroundImage', 'backgroundOrigin', 'backgroundPosition', 'backgroundPositionX', 'backgroundPositionY',
		'backgroundRepeat', 'backgroundRepeatX', 'backgroundRepeatY', 'backgroundSize', 'baselineShift', 'border', 'borderBottom',
		'borderBottomColor', 'borderBottomLeftRadius', 'borderBottomRightRadius', 'borderBottomStyle', 'borderBottomWidth', 'borderCollapse',
		'borderColor', 'borderImage', 'borderImageOutset', 'borderImageRepeat', 'borderImageSlice', 'borderImageSource', 'borderImageWidth',
		'borderLeft', 'borderLeftColor', 'borderLeftStyle', 'borderLeftWidth', 'borderRadius', 'borderRight', 'borderRightColor',
		'borderRightStyle', 'borderRightWidth', 'borderSpacing', 'borderStyle', 'borderTop', 'borderTopColor', 'borderTopLeftRadius',
		'borderTopRightRadius', 'borderTopStyle', 'borderTopWidth', 'borderWidth', 'bottom', 'boxShadow', 'boxSizing', 'bufferedRendering',
		'captionSide', 'clear', 'clip', 'clipPath', 'clipRule', 'color', 'colorInterpolation', 'colorInterpolationFilters', 'colorRendering',
		'content', 'counterIncrement', 'counterReset', 'cursor', 'direction', 'display', 'dominantBaseline', 'emptyCells', 'enableBackground',
		'fill', 'fillOpacity', 'fillRule', 'filter', 'flex', 'flexBasis', 'flexDirection', 'flexFlow', 'flexGrow', 'flexShrink', 'flexWrap',
		'float', 'floodColor', 'floodOpacity', 'font', 'fontFamily', 'fontKerning', 'fontSize', 'fontStretch', 'fontStyle', 'fontVariant',
		'fontVariantLigatures', 'fontWeight', 'glyphOrientationHorizontal', 'glyphOrientationVertical', 'height', 'imageRendering', 'isolation',
		'justifyContent', 'left', 'letterSpacing', 'lightingColor', 'lineHeight', 'listStyle', 'listStyleImage', 'listStylePosition',
		'listStyleType', 'margin', 'marginBottom', 'marginLeft', 'marginRight', 'marginTop', 'marker', 'markerEnd', 'markerMid', 'markerStart',
		'mask', 'maskType', 'maxHeight', 'maxWidth', 'maxZoom', 'minHeight', 'minWidth', 'minZoom', 'mixBlendMode', 'objectFit',
		'objectPosition', 'opacity', 'order', 'orientation', 'orphans', 'outline', 'outlineColor', 'outlineOffset', 'outlineStyle',
		'outlineWidth', 'overflow', 'overflowWrap', 'overflowX', 'overflowY', 'padding', 'paddingBottom', 'paddingLeft', 'paddingRight',
		'paddingTop', 'page', 'pageBreakAfter', 'pageBreakBefore', 'pageBreakInside', 'paintOrder', 'perspectiveOrigin', 'pointerEvents',
		'position', 'quotes', 'resize', 'right', 'shapeImageThreshold', 'shapeMargin', 'shapeOutside', 'shapeRendering', 'size', 'speak',
		'src', 'stopColor', 'stopOpacity', 'stroke', 'strokeDasharray', 'strokeDashoffset', 'strokeLinecap', 'strokeLinejoin',
		'strokeMiterlimit', 'strokeOpacity', 'strokeWidth', 'tabSize', 'tableLayout', 'textAlign', 'textAnchor', 'textDecoration',
		'textIndent', 'textOverflow', 'textRendering', 'textShadow', 'textTransform', 'top', 'touchAction', 'transform', 'transformOrigin',
		'transformStyle', 'transition', 'transitionDelay', 'transitionDuration', 'transitionProperty', 'transitionTimingFunction',
		'unicodeBidi', 'unicodeRange', 'userZoom', 'vectorEffect', 'verticalAlign', 'visibility', 'webkitAnimation', 'webkitAnimationDelay',
		'webkitAnimationDirection', 'webkitAnimationDuration', 'webkitAnimationFillMode', 'webkitAnimationIterationCount',
		'webkitAnimationName', 'webkitAnimationPlayState', 'webkitAnimationTimingFunction', 'webkitAppRegion', 'webkitAppearance',
		'webkitBackfaceVisibility', 'webkitBackgroundClip', 'webkitBackgroundComposite', 'webkitBackgroundOrigin', 'webkitBackgroundSize',
		'webkitBorderAfter', 'webkitBorderAfterColor', 'webkitBorderAfterStyle', 'webkitBorderAfterWidth', 'webkitBorderBefore',
		'webkitBorderBeforeColor', 'webkitBorderBeforeStyle', 'webkitBorderBeforeWidth', 'webkitBorderEnd', 'webkitBorderEndColor',
		'webkitBorderEndStyle', 'webkitBorderEndWidth', 'webkitBorderHorizontalSpacing', 'webkitBorderImage', 'webkitBorderRadius',
		'webkitBorderStart', 'webkitBorderStartColor', 'webkitBorderStartStyle', 'webkitBorderStartWidth', 'webkitBorderVerticalSpacing',
		'webkitBoxAlign', 'webkitBoxDecorationBreak', 'webkitBoxDirection', 'webkitBoxFlex', 'webkitBoxFlexGroup', 'webkitBoxLines',
		'webkitBoxOrdinalGroup', 'webkitBoxOrient', 'webkitBoxPack', 'webkitBoxReflect', 'webkitBoxShadow', 'webkitClipPath',
		'webkitColumnBreakAfter', 'webkitColumnBreakBefore', 'webkitColumnBreakInside', 'webkitColumnCount', 'webkitColumnGap',
		'webkitColumnRule', 'webkitColumnRuleColor', 'webkitColumnRuleStyle', 'webkitColumnRuleWidth', 'webkitColumnSpan',
		'webkitColumnWidth', 'webkitColumns', 'webkitFilter', 'webkitFontFeatureSettings', 'webkitFontSizeDelta', 'webkitFontSmoothing',
		'webkitHighlight', 'webkitHyphenateCharacter', 'webkitLineBoxContain', 'webkitLineBreak', 'webkitLineClamp', 'webkitLocale',
		'webkitLogicalHeight', 'webkitLogicalWidth', 'webkitMarginAfter', 'webkitMarginAfterCollapse', 'webkitMarginBefore',
		'webkitMarginBeforeCollapse', 'webkitMarginBottomCollapse', 'webkitMarginCollapse', 'webkitMarginEnd', 'webkitMarginStart',
		'webkitMarginTopCollapse', 'webkitMask', 'webkitMaskBoxImage', 'webkitMaskBoxImageOutset', 'webkitMaskBoxImageRepeat',
		'webkitMaskBoxImageSlice', 'webkitMaskBoxImageSource', 'webkitMaskBoxImageWidth', 'webkitMaskClip', 'webkitMaskComposite',
		'webkitMaskImage', 'webkitMaskOrigin', 'webkitMaskPosition', 'webkitMaskPositionX', 'webkitMaskPositionY', 'webkitMaskRepeat',
		'webkitMaskRepeatX', 'webkitMaskRepeatY', 'webkitMaskSize', 'webkitMaxLogicalHeight', 'webkitMaxLogicalWidth',
		'webkitMinLogicalHeight', 'webkitMinLogicalWidth', 'webkitPaddingAfter', 'webkitPaddingBefore', 'webkitPaddingEnd',
		'webkitPaddingStart', 'webkitPerspective', 'webkitPerspectiveOrigin', 'webkitPerspectiveOriginX', 'webkitPerspectiveOriginY',
		'webkitPrintColorAdjust', 'webkitRtlOrdering', 'webkitRubyPosition', 'webkitTapHighlightColor', 'webkitTextCombine',
		'webkitTextDecorationsInEffect', 'webkitTextEmphasis', 'webkitTextEmphasisColor', 'webkitTextEmphasisPosition',
		'webkitTextEmphasisStyle', 'webkitTextFillColor', 'webkitTextOrientation', 'webkitTextSecurity', 'webkitTextStroke',
		'webkitTextStrokeColor', 'webkitTextStrokeWidth', 'webkitTransform', 'webkitTransformOrigin', 'webkitTransformOriginX',
		'webkitTransformOriginY', 'webkitTransformOriginZ', 'webkitTransformStyle', 'webkitTransition', 'webkitTransitionDelay',
		'webkitTransitionDuration', 'webkitTransitionProperty', 'webkitTransitionTimingFunction', 'webkitUserDrag', 'webkitUserModify',
		'webkitUserSelect', 'webkitWritingMode', 'whiteSpace', 'widows', 'width', 'willChange', 'wordBreak', 'wordSpacing', 'wordWrap',
		'writingMode', 'zIndex', 'zoom'
	];

	/**
	 * A list of out of the box handlers
	 * for live updating
	 */
	var handlers = {
		'style': handleStyleOverride,
		'text type': handleTextType,
		'unknown' : handleUnknown
	};

	/**
	 * Create a new live update class
	 */
	var LiveUpdate = function()
	{
		this.iframe = $('<iframe />');
		this.handlers = handlers;
	}

	/**
	 * Set the iframe for this live updater
	 */
	LiveUpdate.prototype.setIframe = function(iframe)
	{
		this.iframe = iframe;
	}

	/**
	 * Occasionally it makes sense to refresh the entire
	 * iframe so that we get a new updated view...
	 */
	LiveUpdate.prototype.refresh = function()
	{
		typeof this.iframe[0] !== 'undefined' &&
		typeof this.iframe[0].contentWindow !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location !== 'undefined' &&
		typeof this.iframe[0].contentWindow.location.reload !== 'undefined' &&
		this.iframe[0].contentWindow.location.reload(true);
	}

	/**
	 * Target is the element inside of the iframe that
	 * we will be running our handler on...
	 */
	LiveUpdate.prototype.findTarget = function(node)
	{
		var target = this.iframe.contents().find('[data-devise-' + node.cid + '="' + node.key + '"]');
		return target;
	}

	/**
	 * Handler is a function that runs on a target. We have
	 * built in out of the box handlers for some targets and
	 * the developer can create their own handlers too...
	 */
	LiveUpdate.prototype.findHandler = function(node, targetEl)
	{
		var key = node.key;
		var cid = node.cid;
		var handler = node.handler;
		var target = typeof targetEl === "undefined" ? this.findTarget(node) : targetEl;

		if (typeof this.handlers[handler] === 'function') {
			return this.handlers[handler];
		}

		if (this.isStyle(handler)) {
			return createStyleOverride(handler, this);
		}

		return this.handlers['unknown'];
	}

	/**
	 * Whenever a change happens we need to run a handler
	 * on a target
	 */
	LiveUpdate.prototype.change = function(node, field, input, attribute, value)
	{
		var target = this.findTarget(node);
		var handler = this.findHandler(node);

		handler.apply(this, [target, value, input, attribute, node]);
	}

	/**
	 * Is this a possible style?
	 */
	LiveUpdate.prototype.isStyle = function(style)
	{
		return possibleStyles.indexOf(style) !== -1;
	}

	/**
	 * creates a css property override handler
	 */
	function createStyleOverride(handler, liveupdate)
	{
		return function(target, value, input, attribute, node)
		{
			liveupdate.handlers['style'].apply(liveupdate, [handler, target, value, input, attribute, node]);
		};
	}

	/**
	 * Called as a last resort handler, nothing happens here
	 * unless overriden by the developer...
	 */
	function handleUnknown(target, value, input, attribute, node)
	{

	}

	/**
	 * handles overriding a css style on a target
	 */
	function handleStyleOverride(style, target, value, input, attribute, node)
	{
		var css = {};

		css[style] = value;

		target.css(css);
	}

	/**
	 * handle text type nodes?
	 */
	function handleTextType(target, value, input, attribute, node)
	{

	}

	return LiveUpdate;
});