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
                        :key="gacha.gacha_id"
                    >
                        <MainCard :gacha="gacha" :onGachaUseButtonTap="onGachaUseButtonTap" :onGachaEditButtonTap="onGachaEditButtonTap"/>
                    </div>
                </div>
                <div class="mx-auto mt-2 mb-8" style="font-size: 0.8rem;color: #757575; text-align:center;">{{ messsasge }}</div>
            </Header>
            <v-dialog v-model="showPasswordDialog" max-width="400" @click:outside="resetPasswordDialog">
                <PasswordConfirmCard
                    :onSubmit="onSubmit"
                    @reset-event="setResetPasswordDialog($event)"
                />
            </v-dialog>
        </v-content>
    </v-app>
</template>

<script>
import Header from "../components/Header";
import MainCard from "../components/MainCard";
import InfomationCard from "../components/InfomationCard";
import PasswordConfirmCard from "../components/PasswordConfirmCard";

export default {
    components: {
        Header,
        MainCard,
        InfomationCard,
        PasswordConfirmCard,
    },
    props: {
        _gachas: String
    },
    data: function() {
        return {
            isVisible: true,
            cardWidth: "100%",
            showInfoCard: true,
            showPasswordDialog: false,
            selectedGachaId: null,
            selectedType: null,
            authType: null,
            resetPasswordDialog: () => {},
            messsasge: "現在登録されているガチャは以上です。",
        };
    },
    computed: {
        gachas: function() {
            const gacha = JSON.parse(this._gachas);
            if (!gacha) {
                this.messsasge = "すみません、該当するガチャは見つかりませんでした。"
                return [];
            }
            return gacha;
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
        },
        onGachaUseButtonTap(gachaId, needPassword) {
            if (!needPassword) {
                window.location.href = `/gacha/${gachaId}/machine`
                return
            }
            this.selectedGachaId = gachaId;
            this.selectedType = 'machine';
            this.authType = 0;
            this.showPasswordDialog = true;
        },
        onGachaEditButtonTap(gachaId, needPassword) {
            if (!needPassword) {
                window.location.href = `/gacha/${gachaId}/edit`
                return
            }
            this.selectedGachaId = gachaId;
            this.selectedType = 'edit';
            this.authType = 1;
            this.showPasswordDialog = true;
        },
        onSubmit: async function(password) {
            const request = { password, type: this.authType };
            return await axios.post(`/gacha/${this.selectedGachaId}/auth`, request)
            .then((res) => {
                window.location.href = `/gacha/${res.data}/${this.selectedType}`;
                return true;
            })
            .catch((error) => {
                return false;
            })
        },
        setResetPasswordDialog(event) {
            this.resetPasswordDialog = event;
        },
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
