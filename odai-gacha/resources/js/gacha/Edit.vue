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
                            <div class="d-flex mb-4">
                                <div class="flex-grow-1">
                                    <div class="form-title">タイトル</div>
                                    <TextField 
                                        class="mb-4"
                                        label="タイトル"
                                        :value="gacha.gachaName"
                                        @change="(value) => {gacha.gachaName = value}"
                                        :rules="rules.gachaName"
                                        :counter="50"
                                        :hideDetails="false"
                                    />
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
                                        :hide-details="false"
                                        :value="gacha.description"
                                        @change="(value) => {gacha.description = value}"
                                        :rules="rules.description"
                                        :counter="500"
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
                                        <div class="d-flex align-center mb-2" :key="rarity.rarity">
                                            <TextField
                                                class="flex-grow-1 mr-2"
                                                dense
                                                label="レア度の名前"
                                                disabled
                                                :value="rarity.rarityName"
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
                                <v-tabs class="mb-4" height="40" v-model="tab" color="accent">
                                    <template v-for="rarity in rarities">
                                        <v-tab :key="rarity.rarity">{{ rarity.rarityName }}</v-tab>
                                    </template>
                                </v-tabs>
                                <v-tabs-items v-model="tab" style="min-height: 60px; max-height: 500px; overflow-y: scroll;">
                                    <v-tab-item
                                        v-for="rarity in rarities"
                                        :key="rarity.rarity"
                                    >
                                        <transition-group name="topic-list" tag="div">
                                        <div
                                            v-for="(topic, index) in topics[rarity.rarity]"
                                            class="d-flex align-center mb-2 topic-row"
                                            :key="topic.id"
                                        >
                                            <TextField
                                                class="flex-grow-1 mr-2"
                                                dense
                                                label="ガチャを回した時に出る「お題」を入力してください"
                                                :value="topic.value"
                                                @change="(value) => {onTopicUpdated(value, index, rarity.rarity, topic.id)}"
                                                :rules="rules.topic"
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
                                                    <v-list-item-title>{{ rarity.rarityName }}</v-list-item-title>
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
                                        </transition-group>
                                    </v-tab-item>
                                </v-tabs-items>
                                <div class="mb-2 error--text" style="height:18px; font-size:12px;">{{ topicsError }}</div>
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
                                        color="accent"
                                        v-model="gacha.needUsePass"
                                        inset
                                        label="使用"
                                    ></v-switch>
                                    <div style="width:32px;"></div>
                                    <v-switch
                                        color="accent"
                                        v-model="gacha.needEditPass"
                                        inset
                                        label="編集"
                                    ></v-switch>
                                    <div style="width:32px;"></div>
                                    <v-switch
                                        color="accent"
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
                                    :value="gacha.password"
                                    @change="(value) => {gacha.password = value}"
                                    :hide-details="false"
                                    :rules="rules.password"
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
                                href="/gacha"
                            >
                                キャンセル
                            </v-btn>
                            <v-btn
                                style="width: 200px !important;"
                                depressed
                                color="accent"
                                x-large
                                @click="onSubmit"
                                :disabled="!valid"
                            >
                                作成
                            </v-btn>
                        </div>
                        </v-form>
                    </v-card>
                </div>
                 <v-dialog v-model="dialog" persistent max-width="380">
                    <v-card style="height: 350px; padding: 32px;" class="d-flex flex-column align-center justify-center">
                        <template v-if="dialogState==='loading'">
                            <div class="mb-10">
                                <v-progress-circular
                                    :size="64"
                                    :width="7"
                                    color="accent"
                                    indeterminate
                                ></v-progress-circular>
                            </div>
                            <div class="dialog-message mt-6">登録中...</div>
                        </template>
                        <template v-if="dialogState==='success'">
                            <div class="mb-10">
                              <v-icon color="accent" size="64" class="mb-2 lock-icon">mdi-check-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">
                                登録に成功しました<br>
                                <span class="dialog-sub-message">ガチャ一覧ページに移動します</span>
                            </div>
                        </template>
                        <template v-if="dialogState==='failed'">
                            <div class="mb-10">
                                <v-icon color="primary" size="64" class="mb-2 lock-icon">mdi-close-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">
                                登録に失敗しました<br>
                                <span class="dialog-sub-message">通信状況を確認してください</span>
                            </div>
                            <v-btn
                                class="mt-3"
                                color="#eeeeee"
                                rounded
                                depressed
                                @click="dialog=false"
                                dense
                            >
                                閉じる
                            </v-btn>
                        </template>
                    </v-card>
                </v-dialog>
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
        _gacha: String,
        _rarity: String,
        _topics: String,
    },
    data: function() {
        return {
            valid: false,
            showPassword: false,
            tab: null,
            dialog: false,
            dialogState: 'loading', // loading or success or failed
            gacha: {
                gachaName: null,
                description: null,
                imagePath: null,
                password: null,
                needUsePass: false,
                needEditPass: true,
                needDeletePass: true,
            },
            rarities: [
                { rarity: 0, rarityName: "ノーマル", probability: 50 },
                { rarity: 1, rarityName: "シルバー", probability: 35 },
                { rarity: 2, rarityName: "ゴールド", probability: 13 },
                { rarity: 3, rarityName: "プラチナ", probability: 2 }
            ],
            topics: {},
            topicCount: 0,
            rules: {
                gachaName: [
                    v => !!v || 'タイトルは必須です',
                    v => (v === null || v.length <= 50) || 'タイトルは50文字以内で入力してください'
                ],
                description: [
                    v => (v === null || v.length <= 500) || '説明は500文字以内で入力してください'
                ],
                password: [
                    v => (!this.needPass || !!v) || '使用、編集、削除にロックをかける場合は、パスワードが必須です',
                    v => (v === null || v.length <= 16) || 'パスワードは16文字以内で入力してください',
                ],
                topic: [
                    v => !!v || 'お題には1文字以上入力してください',
                    v => (v === null || v.length <= 30) || 'お題は30文字以内で入力してください'
                ]
            },
            topicsError: "",
        };
    },
    computed: {
        originGacha: function() {
            if (this._gacha === undefined || this._gacha === null || this._gacha === "") {
                return null;
            }
            return JSON.parse(this._gacha);
        },
        originRarity: function() {
            if (this._rarity === undefined || this._rarity === null || this._rarity === "") {
                return null;
            }
            return JSON.parse(this._rarity);
        },
        originTopics: function() {
            if (this._topics === undefined || this._topics === null || this._topics === "") {
                return null;
            }
            return JSON.parse(this._topics);
        },
        topicLength: function() {
            let count = 0;
            for(const key of Object.keys(this.topics)) {
                count += this.topics[key].length;
            }
            return count;
        },
        needPass: function() {
            return this.gacha.needUsePass || this.gacha.needEditPass || this.gacha.needDeletePass;
        },
        isEdit: function() {
            return this.originGacha && this.originRarity && this.originTopics;
        }
    },
    watch: {
        'gacha.needUsePass': function (value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        'gacha.needEditPass': function (value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        'gacha.needDeletePass': function (value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        topics: {
            handler: function (val, oldValue) {
                let count = [];
                let totalCount = 0;
                for(const key of Object.keys(this.topics)) {
                    if (count.key === undefined) {
                        count[key] = 0;
                    }
                    count[key] += this.topics[key].length;
                    totalCount += this.topics[key].length;
                }
                for(const key of Object.keys(this.topics)) {
                    if (count[key] === 0) {
                        this.topicsError = "お題はレア度ごとに1件以上入力してください";
                        this.valid = false;
                        return;
                    }
                }
                if (totalCount > 200) {
                    this.topicsError = "お題は200件以内で入力してください";
                    this.valid = false;
                    return;
                }
                this.topicsError = "";
            },
            deep: true
        }
    },
    mounted() {
        // レア度の初期化
        for (const rarity of this.rarities) {
            this.$set(this.topics, rarity.rarity, [this.Topic()]);
        }
        // 編集の場合
        if (this.isEdit) {
            this.gacha = {
                ...this.gacha,
                gachaName: this.originGacha.gacha_name,
                imagePath: this.originGacha.image_path,
                needUsePass: this.originGacha.needUsePass,
                needEditPass: this.originGacha.needEditPass,
                needDeletePass: this.originGacha.needDeletePass,
            }
            const mapIdToRarity = new Map(this.originRarity.map(rarity => {
                return [rarity.rarity_id, rarity.rarity];
            }));
            for (const topic of this.originTopics) {
                this.topics[mapIdToRarity.get(topic.rarity_id)] = this.Topic(topic.topic);
            }
        }
    },
    methods: {
        Topic(value = "") {
            return {value, id: this.topicCount++}
        },
        async onSubmit() {
            this.dialogState = 'loading';
            this.dialog = true;
            const topics = [];
            for (const rarity of Object.keys(this.topics)) {
                const _topics = this.topics[rarity];
                for (const topic of _topics) {
                    if (!topic.value) {
                        continue;
                    }
                    topics.push({ topic: topic.value, rarity });
                }
            }
            const request = {
                gacha: this.gacha,
                rarity: this.rarities,
                topics: topics
             };
            return await axios.post(`/gacha`, request)
            .then((res) => {
                this.dialogState = 'success';
                window.location.href = `/gacha`;
            })
            .catch((error) => {
                this.dialogState = 'failed';
                console.log(error.response.data.errors)
            })
        },
        addTopic() {
            this.topics[this.tab].push(this.Topic());
        },
        removeTopic(index) {
            this.topics[this.tab].splice(index, 1);
        },
        changeTopicRarity(index, rarity) {
            const moveTopic = this.topics[this.tab].splice(index, 1)[0];
            this.topics[rarity].push(moveTopic);
        },
        onTopicUpdated(value, index, rarity, id) {
            this.topics[rarity][index] = { value, id };
            // 以下バリデーション
            for(const key of Object.keys(this.topics)) {
                for (const topic of this.topics[key]) {
                    if (topic.value === null || topic.value.length < 1 || topic.value.length > 30) {
                        this.topicsError = "お題は1〜30文字で入力してください";
                        return;
                    }
                }
            }
            this.topicsError = "";
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
.topic-list-enter-active, .topic-list-leave-active {
    transition: all 0.2s ease-out;
}
.topic-list-enter {
    opacity: 0;
    transform: translateY(10px);
}
.topic-list-leave-to {
    opacity: 0;
    transform: translateX(100%);
}
.dialog-message {
    text-align: center;
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}
.dialog-sub-message {
    font-size:12px;
    color: #757575;
    font-weight:400;
}
</style>
