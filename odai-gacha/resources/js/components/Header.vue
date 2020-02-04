<template>
    <div>
        <!-- アプリバー -->
        <v-app-bar color="white" elevation="0" fixed>
            <v-app-bar-nav-icon
                style="margin:0;"
                @click="_onNavIconTapped"
                class="d-none d-sm-block"
            ></v-app-bar-nav-icon>
            <div class="d-flex logo">
              <a class="d-flex" href="/gacha">
                <v-img src="../img/logo_icon.png" max-width="30"></v-img>
                <v-toolbar-title class="primary--text font-weight-bold"
                    >お題ガチャ</v-toolbar-title
                >
              </a>
            </div>
            <v-spacer></v-spacer>
            <div
                v-if="showSearchBar"
                class="compact-form d-none d-sm-flex"
                style="max-width: 700px; width: 50%;"
            >
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
                <v-btn
                    depressed
                    color="#F5F0E3"
                    class="ml-1"
                    style="height: 40px;"
                >
                    <v-icon color="grey darken-1">mdi-magnify</v-icon>
                </v-btn>
            </div>
            <v-spacer></v-spacer>
            <v-btn
                v-if="showSearchBar"
                icon
                @click="showSearchForm = true"
                class="d-xs-inline-flex d-sm-none"
            >
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-btn icon @click="infoDialog = true">
                <v-icon>mdi-information-outline</v-icon>
            </v-btn>
            <v-dialog v-model="infoDialog" max-width="700">
                <InfomationCard :onClose="()=>{ infoDialog=false }"/>
            </v-dialog>
        </v-app-bar>
        <!-- 検索バー（スマホサイズのみ） -->
        <div
            v-if="showSearchBar"
            class="search-bar d-xs-flex d-sm-none flex-row align-center"
            :class="{ show: showSearchForm }"
        >
            <v-btn icon @click="showSearchForm = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-text-field
                class="flex-grow-1 mt-3"
                placeholder="検索"
                color="accent"
            ></v-text-field>
            <v-btn icon @click="showSearchForm = false">
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
        </div>
        <!-- サイドバー -->
        <div
            class="sidebar white d-none d-sm-block"
            :class="{ expand: isSidebarExpanded }"
        >
            <div class="my-3">
                <div
                    class="sidebar-button accent white--text"
                    :class="{ expand: isSidebarExpanded }"
                    v-ripple
                    @click="toCreatePage()"
                >
                    <v-icon left color="white">mdi-plus-circle</v-icon>
                    <span v-if="isSidebarExpanded">ガチャ作成</span>
                </div>
            </div>
            <div class="my-3">
                <div
                    class="sidebar-button"
                    :class="{ expand: isSidebarExpanded }"
                    v-ripple
                    @click="infoDialog = true"
                >
                    <v-icon left>mdi-information-outline</v-icon>
                    <span v-if="isSidebarExpanded">本サイトについて</span>
                </div>
            </div>
        </div>
        <!-- FAB（スマホサイズのみ） -->
        <v-btn
            color="accent"
            class="white--text d-xs-block d-sm-none ma-2 fab"
            large
            rounded
            fixed
            elevation="8"
            bottom
            right
            href="/gacha/create"
        >
            <v-icon leff>mdi-plus-circle</v-icon>ガチャ作成
        </v-btn>
        <!-- メインコンテンツ -->
        <div
            class="main-content"
            :class="{ 'with-sidebar-expand': isSidebarExpanded }"
        >
            <slot></slot>
        </div>
    </div>
</template>

<script>
import InfomationCard from "./InfomationCard";
export default {
      components: {
        InfomationCard
    },
    props: {
        onNavIconTapped: {
            type: Function,
            default: () => {}
        },
        showSearchBar: {
            type: Boolean,
            default: true
        }
    },
    data: function() {
        return {
            infoDialog: false,
            showSearchForm: false,
            isSidebarExpanded: true
        };
    },
    methods: {
        _onNavIconTapped() {
            this.isSidebarExpanded = !this.isSidebarExpanded;
            this.$nextTick(function() {
                this.onNavIconTapped();
            });
        },
        toCreatePage() {
            window.location.href = "/gacha/create";
        }
    }
};
</script>

<style scoped>
.compact-form {
    transform: scale(0.9);
    transform-origin: left;
}
.logo {
  user-select: none;
  cursor: pointer;
}
.logo > a {
  text-decoration: none;
}
.search-bar {
    display: flex;
    width: 100%;
    height: 48px;
    padding: 0 8px;
    background: rgba(245, 240, 227, 0.9);
    position: fixed;
    top: -24px;
    left: 0;
    z-index: -1;
    opacity: 0;
    transition: all 0.1s ease-out;
}
.search-bar.show {
    top: 0;
    z-index: 9998;
    opacity: 1;
}
.sidebar {
    position: fixed;
    width: 80px;
    height: 100vh;
    /* margin-top: 64px; */
    padding: 16px 16px 16px 16px;
    overflow: scroll;
    transition: width 0.1s ease-out;
}
.sidebar.expand {
    width: 240px;
}
.sidebar-button {
    user-select: none;
    padding: 0 12px;
    height: 48px;
    width: 48px;
    line-height: 48px;
    font-size: 0.875rem;
    border-radius: 4px;
    cursor: pointer;
    transition: width 0.1s ease-out;
    overflow: hidden;
}
.sidebar-button.expand {
    width: 100%;
}
.fab {
    z-index: 9999;
}
.main-content {
    margin-top: 64px;
    margin-left: 80px;
    width: calc(100% - 80px);
    transition: margin 0.1s ease-out;
}
.main-content.with-sidebar-expand {
    margin-left: 240px;
    width: calc(100% - 240px);
}
@media screen and (max-width: 600px) {
    .main-content {
        width: 100%;
        margin-left: 0px;
    }
    .main-content.with-sidebar-expand {
        width: 100%;
        margin-left: 0px;
    }
}
</style>
