<template>
  <div>
    <v-app-bar color="white" elevation="0" fixed>
      <v-app-bar-nav-icon style="margin:0;"></v-app-bar-nav-icon>
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
    <div class="side-bar white">
      <div class="my-3">
        <v-btn large color="accent" depressed style="width: 100%;" class="side-menu-button">
          <v-icon left>mdi-plus-box</v-icon>ガチャ作成
        </v-btn>
      </div>
      <div class="my-3">
        <v-btn large color="grey darken-3" text style="width: 100%;" class="side-menu-button">
          <v-icon left>mdi-alert-box-outline</v-icon>本サイトについて
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      infoDialog: false
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
  width: 240px;
  height: 100vh;
  margin-top: 64px;
  padding: 16px 16px 16px 16px;
  overflow: scroll;
}
.side-menu-button {
  /* padding: 0 16px !important; */
  font-weight: normal !important;
}
.side-menu-button .v-btn__content {
  justify-content: flex-start !important;
}
</style>