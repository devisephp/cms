<template>
  <fieldset class="dvs-fieldset">
    <input
      type="text"
      v-model.lazy="searchTerm"
      :placeholder="placeholder"
      v-debounce="searchDelay"
    >
    <div class="dvs-relative">
      <ul class="dvs-list-reset dvs-bg-white dvs-text-black dvs-absolute dvs-shadow-lg">
        <li
          v-for="(suggestion, key) in autosuggest.data"
          :key="key"
          class="dvs-border-b dvs-border-grey-lighter dvs-p-4 dvs-cursor-pointer"
          @click="updateValue(index, key, suggestion)"
        >{{ suggestion }}</li>
      </ul>
    </div>
  </fieldset>
</template>

<script>
import debounce from "v-debounce";

import { mapActions } from "vuex";

export default {
  name: "PageSearch",
  data() {
    return {
      searchDelay: 1000,
      searchTerm: "",
      autosuggest: {
        data: []
      }
    };
  },
  methods: {
    ...mapActions("devise", ["searchPages"]),
    updateValue: function(i, id, title) {
      this.searchTerm = "";
      this.autosuggest.data = [];
      this.$emit("selected", {
        index: i,
        id: id,
        title: title
      });
    },
    requestSearch(term) {
      let self = this;
      if (term !== "") {
        this.searchPages(term).then(data => {
          self.autosuggest = data;
          if (data.data.length < 1) {
            devise.$bus.$emit("showMessage", {
              title: "No Suggestions Found",
              message:
                "We couldn't find any values with the term: \"" + term + '".'
            });
          }
        });
      } else {
        this.autosuggest = Object.assign({}, {});
      }
    }
  },
  watch: {
    searchTerm(newValue) {
      this.requestSearch(newValue);
    }
  },
  props: {
    placeholder: {
      type: String,
      default: ""
    },
    index: {
      type: Number,
      default: 0
    }
  },
  directives: {
    debounce
  }
};
</script>
