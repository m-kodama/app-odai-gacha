<template>
    <v-app>
        <v-content>
            <Header :onNavIconTapped="onNavIconTapped">
                <div
                    class="app-main-content"
                    ref="mainContent"
                    v-resize="onResize"
                >
                <div class="px-2 pb-4" v-if="showInfoCard">
                  <InfomationCard :onClose="()=>{ showInfoCard=false }"/>
                </div>
                    <div
                        :style="mainCardStyles"
                        class="main-card-wrapper pa-2"
                        v-for="gacha in gachas"
                        :key="gacha.key"
                    >
                        <!-- // TODO gacah_idに戻す -->
                        <MainCard :gacha="gacha" />
                    </div>
                </div>
            </Header>
        </v-content>
    </v-app>
</template>

<script>
import Header from "../components/Header";
import MainCard from "../components/MainCard";
import InfomationCard from "../components/InfomationCard";

export default {
    components: {
        Header,
        MainCard,
        InfomationCard
    },
    props: {
        _gachas: String
        
    },
    data: function() {
        return {
            isVisible: true,
            cardWidth: "100%",
            showInfoCard: true,
        };
    },
    computed: {
        gachas: function() {
            const originGacha = JSON.parse(this._gachas)[0];
            const gachas = [];
            for (let i = 0; i < 30; i++) {
                const copyGacha = Object.assign({}, { ...originGacha, key: i });
                gachas.push(copyGacha);
            }
            return gachas;
        },
        mainCardStyles() {
            return {
                "--width": this.cardWidth
            };
        }
    },
    mounted() {
        this.onResize();
    },
    methods: {
        onResize() {
            const mainContentWidth = this.$refs.mainContent.clientWidth;
            if (mainContentWidth <= 600) {
                this.cardWidth = "calc(100% / 1)";
            } else if (600 < mainContentWidth && mainContentWidth <= 820) {
                this.cardWidth = "calc(100% / 2)";
            } else if (820 < mainContentWidth && mainContentWidth <= 1220) {
                this.cardWidth = "calc(100% / 3)";
            } else if (1220 < mainContentWidth && mainContentWidth <= 1704) {
                this.cardWidth = "calc(100% / 4)";
            } else if (1704 < mainContentWidth) {
                this.cardWidth = "calc(100% / 5)";
            }
        },
        onNavIconTapped() {
            this.onResize();
        }
    }
};
</script>

<style scoped>
.app-main-content {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    padding: 16px;
}
.main-card-wrapper {
    --width: 100%;
    width: var(--width);
}
</style>
