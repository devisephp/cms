<template>
  <devise-installer-item :item="item" id="nav-image-library" title="Image Library (Required)">
    <template slot="instructions">
      <p>Devise allows users to select images from a media manager and manipulate them. To do this Devise needs ImageMagick (preferred) or GD installed. You don't need both - just one or the other. Getting either library installed can be a little tricky depending on the version of PHP you're running and environment but we have provided a few tips to the right.</p>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">
        Mac OS (using
        <a href="https://brew.sh/" target="_blank">Homebrew</a>)
      </h3>
      <p>On the command line run the following command</p>
      <pre class="lang-bash" data-start="1">
                <code>
                  brew install imagemagick
                </code>
              </pre>
      <p>Or</p>
      <pre class="lang-bash" data-start="1">
                <code>
                  brew install gd
                </code>
              </pre>

      <h3 class="dvs-mb-4">Windows</h3>
      <p>This is very much dependent on what you are using for development but any help you can provide others is greatly appreciated. Please submit any ideas for this section through a pull request.</p>
    </template>
  </devise-installer-item>
</template>

<script>
import Item from './../Item';

export default {
  components: {
    Item
  },
  props: {
    item: {
      required: true
    }
  }
};
</script>
