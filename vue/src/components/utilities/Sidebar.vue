<template>
  <panel
    class="dvs-m-8 dvs-absolute dvs-pin-l dvs-pin-t"
    style="width:300px;"
    :panel-style="theme.panel"
  >
    <div  data-simplebar-auto-hide="true">
      <sidebar-header
        :title="title"
        :backPage="backPage"
        :backText="backText"
        :backCallback="backCallback"
      />
      <div class="dvs-p-8">
        <main-menu :menu-items="menuItems"/>
      </div>
    </div>
  </panel>
</template>

<script>
import Panel from "./../utilities/Panel";
import MainMenu from "./../menu/MainMenu";

export default {
  name: "Sidebar",
  components: {
    MainMenu,
    Panel
  },
  props: ["title", "backPage", "backText", "backCallback", "menuItems"]
};
</script>
