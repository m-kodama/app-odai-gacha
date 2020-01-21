import Vue from "vue";
import App from "./App.vue";
import "@mdi/font/css/materialdesignicons.css";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

new Vue({
    el: "#app",
    vuetify: new Vuetify({
        icons: {
            iconfont: "mdi"
        },
        theme: {
            themes: {
                light: {
                    primary: colors.purple,
                    secondary: colors.grey.darken1,
                    accent: colors.shades.black,
                    error: colors.red.accent3
                },
                dark: {
                    primary: colors.purple,
                    secondary: colors.grey.darken1,
                    accent: colors.shades.black,
                    error: colors.red.accent3
                }
            }
        }
    }),
    template: "<App/>",
    components: { App: App }
});
