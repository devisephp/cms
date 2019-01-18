<template>
  <div>
    <transition name="dvs-fade">
      <div
        class="dvs-fixed dvs-pin dvs-z-50"
        v-show="loadbarPercentage > 0 && loadbarPercentage < 1"
      >
        <div class="dvs-blocker"></div>
        <div
          class="dvs-text-center dvs-w-1/4 dvs-px-4 dvs-py-8 dvs-bg-white dvs-rounded dvs-flex dvs-flex-col dvs-items-center dvs-absolute dvs-absolute-center dvs-z-50"
        >
          <h6 class="dvs-mb-2 dvs-text-action dvs-uppercase dvs-text-xs">Just a moment</h6>
          <div class="dvs-loadbar">
            <div class="dvs-bar dvs-background" :style="{width:loadbarPercentage * 100 + '%'}"></div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loadbarPercentage: 0,
      modulesLoaded: 0
    };
  },
  mounted() {
    // The loadbar works in two ways - listening for incrementations or by
    // passing through a prop. If you pass through a prop it's up to the parent
    // to update the percentage and get to 100%
    if (this.percentage > 0) {
      this.loadbarPercentage = this.percentage;
    } else {
      this.addListeners();
    }
  },
  methods: {
    addListeners() {
      deviseSettings.$bus.$on("incrementLoadbar", this.incrementLoadbar);
    },
    incrementLoadbar(numberOfModulesToLoad) {
      this.modulesLoaded++;
      this.loadbarPercentage = this.modulesLoaded / numberOfModulesToLoad;
      this.checkIfLoaded();
    },
    checkIfLoaded() {
      let self = this;
      if (this.loadbarPercentage >= 1) {
        this.showLoadbar = false;
        setTimeout(function() {
          self.loadbarPercentage = 0;
          self.modulesLoaded = 0;
        }, 1000);
      }
    }
  },
  watch: {
    percentage(newValue) {
      this.loadbarPercentage = newValue;
    }
  },
  props: {
    percentage: {
      type: Number,
      default: -1
    }
  }
};
</script>
