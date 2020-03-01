<template>
    <v-card outlined class="infomation-card pa-8">
        <v-btn icon @click="onClose" style="position: absolute; top: 16px; right: 16px;">
            <v-icon>mdi-close</v-icon>
        </v-btn>
        <div class="d-flex flex-column align-center mb-4">
            <div style="font-weight: bold; font-size: 1.1rem;" class="mb-1">
                このサイトについて
            </div>
            <div class="text">
                このサイトは無料で使えるガチャシュミレーターです。
            </div>
        </div>
        <v-row align="start">
            <v-col cols="12" xs="12" sm="4" class="px-2 py-4">
                <Feature
                    icon="mdi-currency-usd-off"
                    title="完全無料！！"
                    text="このサイトのコンテンツは全て無料で誰でも使用することが可能です。"
                />
            </v-col>
            <v-col cols="12" xs="12" sm="4" class="px-2 py-4">
                <Feature
                    icon="mdi-battlenet"
                    title="ガチャ作成・使用"
                    text="独自のガチャを作成し、遊ぶことができます。公開し世界中に独自のガチャを共有しよう！"
                />
            </v-col>
            <v-col cols="12" xs="12" sm="4" class="px-2 py-4">
                <Feature
                    icon="mdi-lock-outline"
                    title="安心安全"
                    text="自分が作ったガチャは勝手に変更されたり、削除されることはありません！使用も制限可能"
                />
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import Feature from "../components/Feature";

export default {
    components: {
        Feature,
    },
    props: {
        onClose: {
            type: Function,
            default: () => {},
        },
    },
};
</script>

<style scoped>
.infomation-card {
    width: 100%;
}
.text {
    color: #757575;
    font-size: 0.8rem;
    text-align: center;
    width: 80%;
}
</style>
