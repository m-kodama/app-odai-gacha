<template>
    <v-app>
        <v-content>
            <Header :showSearchBar="false">
                <div class="app-main-content">
                    <v-card outlined>
                        <div class="d-flex justify-space-between align-center">
                            <v-card-title>ガチャ作成</v-card-title>
                            <v-btn v-if="this.isEdit" depressed color="#eeeeee" class="px-4" @click="onDeleteButton">
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
                                    :rules="this.needPass ? rules.needPassword : rules.password"
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
                                <template v-if="isEdit">更新</template>
                                <template v-else>作成</template>
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
                            <div class="dialog-message mt-6">
                                <template v-if="isEdit">更新中...</template>
                                <template v-else>作成中...</template>
                            </div>
                        </template>
                        <template v-if="dialogState==='success'">
                            <div class="mb-10">
                              <v-icon color="accent" size="64" class="mb-2 lock-icon">mdi-check-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">
                                <template v-if="isEdit">更新に成功しました</template>
                                <template v-else>作成に成功しました</template>
                                <br>
                                <span class="dialog-sub-message">ガチャ一覧ページに移動します</span>
                            </div>
                        </template>
                        <template v-if="dialogState==='failed'">
                            <div class="mb-10">
                                <v-icon color="primary" size="64" class="mb-2 lock-icon">mdi-close-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">
                                <template v-if="isEdit">更新に失敗しました</template>
                                <template v-else>作成に失敗しました</template>
                                <br>
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
                <v-dialog v-model="deleteDialog" persistent max-width="380">
                    <v-card style="height: 350px; padding: 32px;" class="d-flex flex-column align-center justify-center">
                        <template v-if="deleteDialogState==='confirm'">
                            <div class="mb-10">
                              <v-icon color="primary" size="64" class="mb-2 lock-icon">mdi-delete-alert-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">本当に削除しますか？<br>
                                <span class="dialog-sub-message">削除したガチャは元に戻すことができません</span>
                            </div>
                            <div class="d-flex align-center justify-center mt-3">
                                <v-btn color="#eeeeee" depressed @click="deleteDialog=false" dense style="width:120px !important;">
                                    キャンセル
                                </v-btn>
                                <div style="width:16px;"></div>
                                <v-btn color="primary" depressed @click="deleteGacha" dense style="width:120px !important;">
                                    削除
                                </v-btn>
                            </div>
                        </template>
                        <template v-if="deleteDialogState==='loading'">
                            <div class="mb-10">
                                <v-progress-circular
                                    :size="64"
                                    :width="7"
                                    color="accent"
                                    indeterminate
                                ></v-progress-circular>
                            </div>
                            <div class="dialog-message mt-6">削除中...</div>
                        </template>
                        <template v-if="deleteDialogState==='success'">
                            <div class="mb-10">
                              <v-icon color="accent" size="64" class="mb-2 lock-icon">mdi-check-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">削除に成功しました<br>
                                <span class="dialog-sub-message">ガチャ一覧ページに移動します</span>
                            </div>
                        </template>
                        <template v-if="deleteDialogState==='failed'">
                            <div class="mb-10">
                                <v-icon color="primary" size="64" class="mb-2 lock-icon">mdi-close-outline</v-icon>
                            </div>
                            <div class="dialog-message mt-4">削除に失敗しました<br>
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
                 <v-dialog v-model="showPasswordDialog" max-width="400" @click:outside="resetPasswordDialog">
                <PasswordConfirmCard
                    :onSubmit="onPasswordConfirm"
                    @reset-event="setResetPasswordDialog($event)"
                />
            </v-dialog>
            </Header>
        </v-content>
    </v-app>
</template>

<script>
import Header from "../components/Header";
import TextField from "../components/TextField";
import PasswordConfirmCard from "../components/PasswordConfirmCard";

export default {
    components: {
        Header,
        TextField,
        PasswordConfirmCard
    },
    props: {
        _gacha: Object | Number,
        _rarity: Array | Number,
        _topics: Array | Number,
    },
    data: function() {
        return {
            valid: false,
            showPassword: false,
            tab: null,
            dialog: false,
            dialogState: 'loading', // loading or success or failed
            deleteDialog: false,
            deleteDialogState: 'confirm',
            showPasswordDialog: false,
            resetPasswordDialog: () => {},
            gacha: {
                gachaId: null,
                gachaName: null,
                description: null,
                imagePath: null,
                password: null,
                needUsePass: false,
                needEditPass: true,
                needDeletePass: true,
            },
            rarities: [
                { rarityId: null, rarity: 0, rarityName: "ノーマル", probability: 50 },
                { rarityId: null, rarity: 1, rarityName: "シルバー", probability: 35 },
                { rarityId: null, rarity: 2, rarityName: "ゴールド", probability: 13 },
                { rarityId: null, rarity: 3, rarityName: "プラチナ", probability: 2 }
            ],
            topics: {},
            removedTopics: [],
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
                    v => (v === null || v.length <= 16) || 'パスワードは16文字以内で入力してください',
                ],
                needPassword: [
                    v => !!v || '使用、編集、削除にロックをかける場合は、パスワードが必須です',
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
            return !!this._gacha && !!this._rarity && !!this._topics;
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
            this.$set(this.topics, rarity.rarity, []);
        }
        // console.log(this.isEdit);
        // console.log(this._gacha);
        // console.log(this._rarity);
        // console.log(this._topics);
        // 編集の場合
        if (this.isEdit) {
            this.gacha = {
                ...this.gacha,
                gachaId: this._gacha.gacha_id,
                gachaName: this._gacha.gacha_name,
                description: this._gacha.description,
                imagePath: this._gacha.image_path,
                needUsePass: this._gacha.needUsePass,
                needEditPass: this._gacha.needEditPass,
                needDeletePass: this._gacha.needDeletePass,
            }
            this.rarities = [];
            for (const rarity of this._rarity) {
                this.rarities.push({
                    rarityId: rarity.rarity_id,
                    rarity: rarity.rarity,
                    rarityName: rarity.rarity_name,
                    probability: rarity.probability / 10 });
            }
            const mapIdToRarity = new Map(this._rarity.map(rarity => {
                return [rarity.rarity_id, rarity.rarity];
            }));
            for (const topic of this._topics) {
                this.topics[mapIdToRarity.get(topic.rarity_id)].push(this.Topic(topic.topic, topic.topic_id));
            }
        } else {
            for (const rarity of this.rarities) {
                this.topics[rarity.rarity].push(this.Topic())
            }
        }
    },
    methods: {
        Topic(value = "", topicId = null) {
            return {value, id: this.topicCount++, topicId};
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
                    topics.push({ topicId: topic.topicId, topic: topic.value, rarity });
                }
            }
            const request = {
                gacha: this.gacha,
                rarity: this.rarities,
                topics: topics,
                removedTopics: this.removedTopics
             };
            const method = this.isEdit ? axios.put(`/gacha/${this._gacha.gacha_id}`, request) :axios.post(`/gacha`, request);
            return await method
            .then((res) => {
                this.dialogState = 'success';
                window.location.href = `/gacha`;
            })
            .catch((error) => {
                this.dialogState = 'failed';
                // console.log(error.response.data.errors);
            })
        },
        addTopic() {
            this.topics[this.tab].push(this.Topic());
        },
        removeTopic(index) {
            const removed = this.topics[this.tab].splice(index, 1)[0];
            if (removed.topicId !== null) {
                this.removedTopics.push(removed);
            }
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
        },
        onDeleteButton() {
            if (this._gacha.needDeletePass) {
                this.showPasswordDialog = true;
            } else {
                this.deleteDialogState = 'confirm';
                this.deleteDialog = true;
            }
        },
        async deleteGacha() {
            this.deleteDialogState = 'loading';
            await axios.delete(`/gacha/${this._gacha.gacha_id}`, {})
            .then((res) => {
                this.deleteDialogState = 'success';
                window.location.href = `/gacha`;
            })
            .catch((error) => {
                this.deleteDialogState = 'failed';
                // console.log(error.response.data.errors);
            })
        },
        async onPasswordConfirm(password) {
            const request = { password, type: 2 };
            return await axios.post(`/gacha/${this._gacha.gacha_id}/auth`, request)
            .then((res) => {
                this.showPasswordDialog = false;
                this.deleteDialogState = 'confirm';
                this.deleteDialog = true;
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
