<template>
  <div>
    <v-app-bar color="white" elevation="0" fixed>
      <v-app-bar-nav-icon style="margin:0;" @click="isSidebarExpanded = !isSidebarExpanded"></v-app-bar-nav-icon>
      <v-img src="../img/logo_icon.png" max-width="30"></v-img>
      <v-toolbar-title class="primary--text font-weight-bold">お題ガチャ</v-toolbar-title>

      <v-spacer></v-spacer>
      <div class="d-flex compact-form" style="max-width: 700px; width: 50%;">
        <v-text-field
          color="accent"
          outlined
          solo
          flat
          placeholder="検索"
          dense
          clearable
          hide-details
        ></v-text-field>
        <v-btn depressed color="#F5F0E3" class="ml-1" style="height: 40px;">
          <v-icon color="grey darken-1">mdi-magnify</v-icon>
        </v-btn>
      </div>
      <v-spacer></v-spacer>

      <v-btn icon @click="infoDialog=true">
        <v-icon>mdi-information-outline</v-icon>
      </v-btn>
      <v-dialog v-model="infoDialog" max-width="700">
        <v-card>がちゃです</v-card>
      </v-dialog>
    </v-app-bar>
    <div class="side-bar white" :class="{expand: isSidebarExpanded}">
      <div class="my-3">
        <div
          class="side-bar-button accent white--text"
          :class="{expand: isSidebarExpanded}"
          v-ripple
        >
          <v-icon left color="white">mdi-plus-box</v-icon>
          <span v-if="isSidebarExpanded">ガチャ作成</span>
        </div>
      </div>
      <div class="my-3">
        <div class="side-bar-button" :class="{expand: isSidebarExpanded}" v-ripple>
          <v-icon left>mdi-alert-box-outline</v-icon>
          <span v-if="isSidebarExpanded">本サイトについて</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      infoDialog: false,
      isSidebarExpanded: true
    };
  }
};
</script>

<style>
.compact-form {
  transform: scale(0.9);
  transform-origin: left;
}
.side-bar {
  position: fixed;
  width: 80px;
  height: 100vh;
  margin-top: 64px;
  padding: 16px 16px 16px 16px;
  overflow: scroll;
  transition: width 0.2s ease-out;
}
.side-bar.expand {
  width: 240px;
}
.side-bar-button {
  padding: 0 12px;
  height: 48px;
  width: 48px;
  line-height: 48px;
  font-size: 0.875rem;
  border-radius: 4px;
  cursor: pointer;
  transition: width 0.2s ease-out;
  overflow: hidden;
}
.side-bar-button.expand {
  width: 100%;
}
</style>