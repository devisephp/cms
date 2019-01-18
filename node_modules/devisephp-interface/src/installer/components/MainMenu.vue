<template>
  <div id="sidebar" class="dvs-absolute dvs-pin-l dvs-pin-t dvs-pin-b dvs-bg-grey-lighter dvs-p-4">
    <scrollactive
      :offset="80"
      :duration="800"
      bezier-easing-value=".5,0,.35,1"
      scroll-container-selector="#content"
      id="menu"
    >
      <ul class="dvs-list-reset">
        <li>
          <a href="#nav-welcome" class="scrollactive-item">Welcome</a>
        </li>
        <li>
          <a href="#nav-required" class="scrollactive-item">Required</a>
          <ul class="dvs-list-reset dvs-ml-4">
            <li class="dvs-flex">
              <item-check :item="checklist.database" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-database-connection" class="scrollactive-item">Database Connection</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.migrations" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-database-migration" class="scrollactive-item">Database Migration</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.auth" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-auth" class="scrollactive-item">Authentication</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.user" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-user" class="scrollactive-item">First User</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.site" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-site" class="scrollactive-item">First Site</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.page" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-page" class="scrollactive-item">First Page</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.slices" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-slices" class="scrollactive-item">Slices Directory</a>
            </li>
            <li class="dvs-flex">
              <item-check :item="checklist.image_library" :size="15" class="dvs-mr-2"></item-check>
              <a href="#nav-image-library" class="scrollactive-item">Image Library</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nav-suggested" class="scrollactive-item">Suggested</a>
          <ul class="dvs-list-reset dvs-ml-4">
            <li class="dvs-flex">
              <a href="#nav-remove-laravel-route" class="scrollactive-item">Remove Laravel Routes</a>
            </li>
            <li>
              <a href="#nav-image-optimization" class="scrollactive-item">Image Optimization</a>
              <ul>
                <li class="dvs-flex">
                  <item-check
                    :item="checklist.image_optimization.gifsicle"
                    :size="15"
                    class="dvs-mr-2"
                  ></item-check>
                  <a href="#nav-image-optimization" class="scrollactive-item">Gifsicle</a>
                </li>
                <li class="dvs-flex">
                  <item-check
                    :item="checklist.image_optimization.jpegoptim"
                    :size="15"
                    class="dvs-mr-2"
                  ></item-check>
                  <a href="#nav-image-optimization" class="scrollactive-item">Jpegoptim</a>
                </li>
                <li class="dvs-flex">
                  <item-check
                    :item="checklist.image_optimization.optipng"
                    :size="15"
                    class="dvs-mr-2"
                  ></item-check>
                  <a href="#nav-image-optimization" class="scrollactive-item">Optipng</a>
                </li>
                <li class="dvs-flex">
                  <item-check
                    :item="checklist.image_optimization.pngquant"
                    :size="15"
                    class="dvs-mr-2"
                  ></item-check>
                  <a href="#nav-image-optimization" class="scrollactive-item">Pngquant</a>
                </li>
                <li class="dvs-flex">
                  <item-check :item="checklist.image_optimization.svgo" :size="15" class="dvs-mr-2"></item-check>
                  <a href="#nav-image-optimization" class="scrollactive-item">Svgo</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </scrollactive>
  </div>
</template>

<script>
export default {
  props: {
    checklist: {
      required: true
    }
  }
};
</script>
