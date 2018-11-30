<template>
  <devise-installer-item
    :item="checklist.image_optimization.jpegoptim || checklist.image_optimization.optipng || checklist.image_optimization.pngquant || checklist.image_optimization.svgo || checklist.image_optimization.gifsicle"
    id="nav-image-optimization"
    title="Image Optimization (Optional)"
  >
    <template slot="instructions">
      <p>When images are uploaded to the media manager nothing happens. We store the highest resolution image we can. However, when a user select's an image when populating content Devise will attempt to optimize the image by running a series of optimizations depending on file type. These are not required but you can greatly increase the performance for end-users by having these installed.</p>
    </template>

    <template slot="example">
      <h3 class="dvs-mb-4">
        Mac OS (using
        <a href="https://brew.sh/" target="_blank">Homebrew</a>)
      </h3>
      <p>On the command line run the following command</p>
      <pre class="lang-bash" data-start="1">
                <code>
                  brew install jpegoptim
                  brew install optipng
                  brew install pngquant
                  brew install svgo
                  brew install gifsicle
                </code>
              </pre>

      <h3 class="dvs-mb-4">Ubuntu</h3>
      <p>On the command line run the following command</p>
      <pre class="lang-bash" data-start="1">
                <code>
                  sudo apt-get install jpegoptim
                  sudo apt-get install optipng
                  sudo apt-get install pngquant
                  sudo npm install -g svgo
                  sudo apt-get install gifsicle
                </code>
              </pre>
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
    checklist: {
      required: true
    }
  }
};
</script>
