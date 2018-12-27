export default function(el, binding, vnode) {
  let image = binding.value.image;
  let srcAttribute = binding.value.srcAttr;
  let breakpoint = binding.value.breakpoint;
  let background = binding.modifiers.background;
  let noSize = binding.modifiers.nosize;

  breakpoint = breakpoint !== null ? breakpoint : 'desktop';
  srcAttribute = srcAttribute ? srcAttribute : 'src';

  let theImageSize = () => {
    let sizes = image.sizes;

    for (const size in sizes) {
      if (sizes.hasOwnProperty(size)) {
        const sizeSettings = sizes[size];

        // If breakpoints isn't set assume only one size and return it
        if (!sizeSettings.breakpoints) {
          return { size: size, settings: sizeSettings };
        }
        if (sizeSettings.breakpoints.includes(breakpoint)) {
          return { size: size, settings: sizeSettings };
        }
      }
    }
  };

  let theSize = theImageSize();

  // Default the image the url but if it does have a size match
  // set that instead
  let theImage = image.url;
  if (theSize) {
    // In the case where sizes are set but the url is manual
    // (or maybe the image media wasn't generated) this will ensure
    // the url is at least present from the media property
    if (image.media[theSize.size]) {
      theImage = image.media[theSize.size];
    }
  }

  if (background) {
    el.style.backgroundImage = `url(${theImage})`;
  } else {
    el[srcAttribute] = theImage;

    if (image.alt) {
      el.alt = image.alt;
    }

    if (!noSize && theSize) {
      el.width = theSize.settings.w;
      el.height = theSize.settings.h;
    }
  }
}
