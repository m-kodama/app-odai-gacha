<template>
    <v-app>
        <v-content>
            <Header :showSearchBar="false">
                <div class="app-main-content">
                    <v-card outlined>
                        <div class="d-flex justify-space-between align-center">
                            <v-card-title>ガチャ作成</v-card-title>
                            <v-btn depressed color="#eeeeee" class="px-4">
                                削除
                            </v-btn>
                        </div>
                        <v-form v-model="valid" autocomplete="off">
                        <div class="card-content">
                            <!-- タイトル・説明・サムネイル画像s -->
                            <div class="d-flex mb-8">
                                <div class="flex-grow-1">
                                    <div class="form-title">タイトル</div>
                                    <TextField class="mb-8" label="タイトル" />
                                    <div class="form-title">
                                        このガチャの説明
                                    </div>
                                    <v-textarea
                                        color="accent"
                                        outlined
                                        solo
                                        flat
                                        label="このガチャの説明や使い方などを入力してください"
                                        clearable
                                        hide-details
                                    ></v-textarea>
                                </div>
                                <div
                                    style="width: 200px; padding-top:27px;"
                                    class="ml-4"
                                >
                                    <v-tooltip top>
                                    <template v-slot:activator="{ on }">
                                    <div
                                        style="border-radius: 4px; background:rgba(0,0,0,.12); height: 100%; width:100%; user-select:none;"
                                        class="d-flex flex-column justify-center align-center"
                                        v-on="on"
                                    >
                                        <v-icon
                                            color="rgba(0,0,0,.26)"
                                            large
                                            class="mb-3"
                                            >mdi-cloud-upload</v-icon
                                        >
                                        <div
                                            style="color: rgba(0,0,0,.26); font-size:0.9rem; font-weight: bold;"
                                            class="mb-1"
                                        >
                                            サムネイル画像
                                        </div>
                                        <div
                                            style="color: rgba(0,0,0,.26); font-size:0.7rem;"
                                        >
                                            (960 x 600)
                                        </div>
                                    </div>
                                    </template>
                                    <span>現在準備中です...</span>
                                    </v-tooltip>
                                </div>
                            </div>
                            <!-- レア度 -->
                            <v-tooltip top left>
                            <template v-slot:activator="{ on }">
                            <div class="mb-8" v-on="on">
                                <div class="form-title">レア度</div>
                                <div class="mb-4">
                                    <template v-for="rarity in rarities">
                                        <div class="d-flex align-center mb-2">
                                            <TextField
                                                class="flex-grow-1 mr-2"
                                                dense
                                                label="レア度の名前"
                                                disabled
                                                :value="rarity.rarity_name"
                                            />
                                            <div
                                                class="mr-4"
                                                style="width:80px;"
                                            >
                                                <TextField
                                                    dense
                                                    label="確率"
                                                    suffix="%"
                                                    type="number"
                                                    disabled
                                                    :value="rarity.probability"
                                                    :clearable="false"
                                                />
                                            </div>
                                            <v-btn
                                                depressed
                                                color="#eeeeee"
                                                class="px-4"
                                                disabled
                                            >
                                                <v-icon color="grey darken-1"
                                                    >mdi-delete-forever</v-icon
                                                >
                                            </v-btn>
                                        </div>
                                    </template>
                                </div>
                                <div class="d-flex justify-center">
                                    <v-btn
                                        style="width: 50% !important; min-width: 120px; color: #333;"
                                        color="secondary"
                                        rounded
                                        depressed
                                        disabled
                                    >
                                        <v-icon leff>mdi-plus</v-icon>レア度追加
                                    </v-btn>
                                </div>
                            </div>
                            </template>
                            <span>現在準備中です...</span>
                            </v-tooltip>
                            <!-- お題 -->
                            <div class="mb-8">
                                <div class="form-title">お題</div>
                                <v-tabs class="mb-4" height="40" v-model="tab">
                                    <template v-for="rarity in rarities">
                                        <v-tab>{{ rarity.rarity_name }}</v-tab>
                                    </template>
                                </v-tabs>
                                <v-tabs-items v-model="tab" class="mb-4" style="min-height: 60px; max-height: 500px; overflow-y: scroll;">
                                    <v-tab-item
                                        v-for="rarity in rarities"
                                        :key="rarity.rarity"
                                    >
                                        <template v-for="(topic, index) in topics[rarity.rarity]">
                                        <div class="d-flex align-center mb-2" :key="topic.id">
                                            <TextField
                                                class="flex-grow-1 mr-2"
                                                dense
                                                label="ガチャを回した時に出る「お題」を入力してください"
                                                :v-model="topic.value"
                                            />
                                            <v-menu
                                                transition="slide-x-transition"
                                                bottom
                                                left
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <div
                                                        class="square-button mr-4 d-flex align-center justify-center"
                                                        v-ripple
                                                        v-on="on"
                                                    >
                                                        <v-icon color="grey darken-1">mdi-arrow-right</v-icon
                                                        >
                                                    </div>
                                                </template>
                                                <v-list>
                                                    <v-list-item
                                                        style="font-size:0.5rerm;"
                                                        v-for="rarity in rarities"
                                                        :key="rarity.rarity"
                                                        @click="changeTopicRarity(index, rarity.rarity)"
                                                        :disabled="rarity.rarity === tab"
                                                    >
                                                    <v-list-item-title>{{ rarity.rarity_name }}</v-list-item-title>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>
                                            <v-btn
                                                depressed
                                                color="#eeeeee"
                                                class="px-4"
                                                @click="removeTopic(index)"
                                            >
                                                <v-icon color="grey darken-1"
                                                    >mdi-delete-forever</v-icon
                                                >
                                            </v-btn>
                                        </div>
                                        </template>
                                    </v-tab-item>
                                </v-tabs-items>
                                <div class="d-flex justify-center">
                                    <v-btn
                                        style="width: 50% !important; min-width: 120px; color: #333;"
                                        color="secondary"
                                        rounded
                                        depressed
                                        @click="addTopic"
                                    >
                                        <v-icon leff>mdi-plus</v-icon>お題追加
                                    </v-btn>
                                </div>
                            </div>
                            <!-- パスワード -->
                            <div class="mb-8">
                                <div class="form-title">パスワード</div>
                                <div class="form-description">
                                    ガチャの使用、編集、削除にパスワードをかけたい場合は、スイッチをONにしてください
                                </div>
                                <div class="d-flex">
                                    <div style="width:8px;"></div>
                                    <v-switch
                                        color="primary"
                                        v-model="gacha.needUsePass"
                                        inset
                                        label="使用"
                                    ></v-switch>
                                    <div style="width:32px;"></div>
                                    <v-switch
                                        color="primary"
                                        v-model="gacha.needEditPass"
                                        inset
                                        label="編集"
                                    ></v-switch>
                                    <div style="width:32px;"></div>
                                    <v-switch
                                        color="primary"
                                        v-model="gacha.needDeletePass"
                                        inset
                                        label="削除"
                                    ></v-switch>
                                </div>
                                <TextField
                                    class="mb-2"
                                    label="パスワード"
                                    :clearable="false"
                                    :append-icon="
                                        showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    :type="showPassword ? 'text' : 'password'"
                                    :clickAppend="
                                        () => (showPassword = !showPassword)
                                    "
                                    :disabled="!(gacha.needUsePass || gacha.needEditPass || gacha.needDeletePass)"
                                />
                                <div
                                    class="pa-2 warning white--text"
                                    style="border-radius: 4px; font-size:0.9rem;"
                                >
                                    パスワードはガチャを起動、編集および削除する際に必要になります。<br />
                                    設定したパスワードは忘れないよう必ず保管してください。
                                </div>
                            </div>
                        </div>
                        <!-- ボタン -->
                        <div class="d-flex justify-center align-center mb-4">
                            <v-btn
                                style="width: 200px !important;"
                                depressed
                                outlined
                                color="#aeaeae"
                                class="mr-4"
                                x-large
                            >
                                キャンセル
                            </v-btn>
                            <v-btn
                                style="width: 200px !important;"
                                depressed
                                color="accent"
                                x-large
                            >
                                作成
                            </v-btn>
                        </div>
                        </v-form>
                    </v-card>
                </div>
            </Header>
        </v-content>
    </v-app>
</template>

<script>
import Header from "../components/Header";
import TextField from "../components/TextField";

export default {
    components: {
        Header,
        TextField
    },
    props: {
        _gachas: String
    },
    data: function() {
        return {
            valid: false,
            showPassword: false,
            tab: null,
            gacha: {
                gacha_name: "",
                description: "",
                image_path: "",
                password: "",
                needUsePass: false,
                needEditPass: true,
                needDeletePass: true,
            },
            rarities: [
                { rarity: 0, rarity_name: "ノーマル", probability: 50 },
                { rarity: 1, rarity_name: "シルバー", probability: 35 },
                { rarity: 2, rarity_name: "ゴールド", probability: 13 },
                { rarity: 3, rarity_name: "プラチナ", probability: 2 }
            ],
            topics: {},
            topicCount: 0,
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
        }
    },
    mounted() {
        for (const rarity of this.rarities) {
            this.$set(this.topics, rarity.rarity, [this.Topic()]);
        }
    },
    methods: {
        Topic(value = "") {
            return {value, id: this.topicCount++}
        },
        onSubmit() {},
        addTopic() {
            this.topics[this.tab].push(this.Topic());
        },
        removeTopic(index) {
            this.topics[this.tab].splice(index, 1);
            if (this.topics[this.tab].length === 0){
                this.topics[this.tab].push(this.Topic());
            }
        },
        changeTopicRarity(index, rarity) {
            const moveTopic = this.topics[this.tab].splice(index, 1)[0];
            this.topics[rarity].push(moveTopic);
        }
    }
};
</script>

<style scoped>
.app-main-content {
    width: 100%;
    padding: 16px;
    display: flex;
    justify-content: center;
}
.v-card {
    width: 100%;
    max-width: 960px;
    padding: 16px;
}
.card-content {
    padding: 32px;
}
.form-title {
    font-size: 0.9rem;
    font-weight: bold;
    color: #333;
    margin: 0 0 6px 4px;
}
.form-description {
    font-size: 0.8rem;
    color: #757575;
    margin: 0 0 6px 4px;
}
.square-button {
    height: 40px;
    width: 40px;
    border-radius: 4px;
    cursor: pointer;
    border: solid 1px #aeaeae;
}
.v-list-item__title {
    font-size: 0.9rem !important;
}
</style>
