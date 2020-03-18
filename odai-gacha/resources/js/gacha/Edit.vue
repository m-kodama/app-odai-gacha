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
                                            @change="
                                                value => {
                                                    gacha.gachaName = value;
                                                }
                                            "
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
                                            @change="
                                                value => {
                                                    gacha.description = value;
                                                }
                                            "
                                            :rules="rules.description"
                                            :counter="500"
                                        ></v-textarea>
                                    </div>
                                    <div style="width: 200px; padding-top:27px;" class="ml-4">
                                        <v-tooltip top>
                                            <template v-slot:activator="{ on }">
                                                <div
                                                    style="border-radius: 4px; background:rgba(0,0,0,.12); height: 100%; width:100%; user-select:none;"
                                                    class="d-flex flex-column justify-center align-center"
                                                    v-on="on"
                                                >
                                                    <v-icon color="rgba(0,0,0,.26)" large class="mb-3"
                                                        >mdi-cloud-upload</v-icon
                                                    >
                                                    <div
                                                        style="color: rgba(0,0,0,.26); font-size:0.9rem; font-weight: bold;"
                                                        class="mb-1"
                                                    >
                                                        サムネイル画像
                                                    </div>
                                                    <div style="color: rgba(0,0,0,.26); font-size:0.7rem;">
                                                        (960 x 600)
                                                    </div>
                                                </div>
                                            </template>
                                            <span>現在準備中です...</span>
                                        </v-tooltip>
                                    </div>
                                </div>
                                <!-- レア度 -->
                                <div class="mb-8">
                                    <div class="form-title">レア度</div>
                                    <PercentageSlider
                                        class="mb-2"
                                        title="排出率"
                                        :images="images"
                                        :rarities="rarities"
                                        @change="
                                            rarities => {
                                                rarities.forEach((rarity, index) => {
                                                    updateProbability(index, rarity);
                                                });
                                            }
                                        "
                                    ></PercentageSlider>
                                    <div class="mb-4">
                                        <template v-for="(rarity, index) in rarities">
                                            <div class="d-flex align-center mb-2" :key="rarity.id">
                                                <v-menu
                                                    transition="scale-transition"
                                                    origin="center center"
                                                    :nudge-left="(48 * 4 + 8 * 2 - 40) / 2"
                                                    :nudge-top="(48 * 3 + 8 * 2 - 40) / 2"
                                                >
                                                    <template v-slot:activator="{ on }">
                                                        <div
                                                            class="square-button mr-2 d-flex align-center justify-center pa-1"
                                                            v-ripple
                                                            v-on="on"
                                                        >
                                                            <v-img
                                                                :src="
                                                                    `/img/${rarityImageMap.get(rarity.rarityImageId)}`
                                                                "
                                                                aspect-ratio="1"
                                                                contain
                                                                v-if="rarity.rarityImageId !== null"
                                                            ></v-img>
                                                        </div>
                                                    </template>
                                                    <v-card
                                                        class="d-flex align-center justify-start flex-wrap pa-2"
                                                        :width="48 * 4 + 8 * 2"
                                                    >
                                                        <v-hover
                                                            v-slot:default="{ hover }"
                                                            v-for="rarityImage in rarityImages"
                                                            :key="rarityImage.rarity_image_id"
                                                        >
                                                            <div
                                                                class="pa-1"
                                                                :class="{
                                                                    'rarity-image-selection-hover': hover,
                                                                    'rarity-image-selection-selected':
                                                                        rarityImage.rarity_image_id ===
                                                                        rarity.rarityImageId,
                                                                }"
                                                                v-ripple
                                                                @click="
                                                                    updateRarityImage(
                                                                        index,
                                                                        rarityImage.rarity_image_id,
                                                                    )
                                                                "
                                                                style="height: 48px; width: 48px; border-radius: 4px; cursor: pointer;"
                                                            >
                                                                <v-img
                                                                    :src="`/img/${rarityImage.rarity_image_path}`"
                                                                    aspect-ratio="1"
                                                                    contain
                                                                ></v-img>
                                                            </div>
                                                        </v-hover>
                                                    </v-card>
                                                </v-menu>
                                                <TextField
                                                    class="flex-grow-1 mr-2"
                                                    dense
                                                    label="レア度の名前"
                                                    :value="rarity.rarityName"
                                                    @change="
                                                        value => {
                                                            updateRarityName(index, value);
                                                        }
                                                    "
                                                />
                                                <div class="percentage-box mr-4 d-flex align-center justify-end pa-2">
                                                    <div>{{ rarity.probability }} %</div>
                                                </div>
                                                <v-btn
                                                    depressed
                                                    color="#eeeeee"
                                                    class="px-4"
                                                    @click="removeRarity(index)"
                                                >
                                                    <v-icon color="grey darken-1">mdi-delete-forever</v-icon>
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
                                            @click="addRarity()"
                                        >
                                            <v-icon leff>mdi-plus</v-icon>レア度追加
                                        </v-btn>
                                    </div>
                                </div>
                                <!-- お題 -->
                                <div class="mb-8">
                                    <div class="form-title">お題</div>
                                    <v-tabs class="mb-4" height="40" v-model="tab" color="accent">
                                        <template v-for="rarity in rarities">
                                            <v-tab :key="rarity.id">{{ rarity.rarityName }}</v-tab>
                                        </template>
                                    </v-tabs>
                                    <v-tabs-items
                                        v-model="tab"
                                        style="min-height: 60px; max-height: 500px; overflow-y: scroll;"
                                    >
                                        <v-tab-item v-for="rarity in rarities" :key="rarity.id">
                                            <transition-group name="topic-list" tag="div">
                                                <div
                                                    v-for="(topic, index) in topics[rarity.id]"
                                                    class="d-flex align-center mb-2 topic-row"
                                                    :key="topic.id"
                                                >
                                                    <TextField
                                                        class="flex-grow-1 mr-2"
                                                        dense
                                                        label="ガチャを回した時に出る「お題」を入力してください"
                                                        :value="topic.value"
                                                        @change="
                                                            value => {
                                                                onTopicUpdated(
                                                                    value,
                                                                    index,
                                                                    rarity.id,
                                                                    topic.id,
                                                                    topic.topicId,
                                                                );
                                                            }
                                                        "
                                                        :rules="rules.topic"
                                                    />
                                                    <v-menu transition="slide-x-transition" bottom left>
                                                        <template
                                                            v-slot:activator="{
                                                                on,
                                                            }"
                                                        >
                                                            <div
                                                                class="square-button mr-4 d-flex align-center justify-center"
                                                                v-ripple
                                                                v-on="on"
                                                            >
                                                                <v-icon color="grey darken-1">mdi-arrow-right</v-icon>
                                                            </div>
                                                        </template>
                                                        <v-list>
                                                            <v-list-item
                                                                style="font-size:0.5rerm;"
                                                                v-for="rarity in rarities"
                                                                :key="rarity.id"
                                                                @click="changeTopicRarity(index, rarity.id)"
                                                                :disabled="rarity.id === tab"
                                                            >
                                                                <v-list-item-title>{{
                                                                    rarity.rarityName
                                                                }}</v-list-item-title>
                                                            </v-list-item>
                                                        </v-list>
                                                    </v-menu>
                                                    <v-btn
                                                        depressed
                                                        color="#eeeeee"
                                                        class="px-4"
                                                        @click="removeTopic(index)"
                                                    >
                                                        <v-icon color="grey darken-1">mdi-delete-forever</v-icon>
                                                    </v-btn>
                                                </div>
                                            </transition-group>
                                        </v-tab-item>
                                    </v-tabs-items>
                                    <div class="mb-2 error--text" style="height:18px; font-size:12px;">
                                        {{ topicsError }}
                                    </div>
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
                                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="showPassword ? 'text' : 'password'"
                                        :clickAppend="() => (showPassword = !showPassword)"
                                        :disabled="!(gacha.needUsePass || gacha.needEditPass || gacha.needDeletePass)"
                                        :value="gacha.password"
                                        @change="
                                            value => {
                                                gacha.password = value;
                                            }
                                        "
                                        :hide-details="false"
                                        :rules="this.needPass ? rules.needPassword : rules.password"
                                    />
                                    <div class="pa-2 warning white--text" style="border-radius: 4px; font-size:0.9rem;">
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
                <EditDialog
                    :show="dialog"
                    @change="
                        value => {
                            dialog = value;
                        }
                    "
                    :onComplete="moveTopPage"
                    :onConfirm="onDeleteConfirm"
                    :state="dialogState"
                    :action="dialogAction"
                />
                <v-dialog v-model="showPasswordDialog" max-width="400" @click:outside="resetPasswordDialog">
                    <PasswordConfirmCard :onSubmit="onPasswordConfirm" @reset-event="setResetPasswordDialog($event)" />
                </v-dialog>
            </Header>
        </v-content>
    </v-app>
</template>

<script>
import Header from "../components/Header";
import TextField from "../components/TextField";
import PasswordConfirmCard from "../components/PasswordConfirmCard";
import EditDialog from "../components/EditDialog";
import PercentageSlider from "../components/PercentageSlider";

export default {
    components: {
        Header,
        TextField,
        PasswordConfirmCard,
        EditDialog,
        PercentageSlider,
    },
    props: {
        _gacha: Object | Number,
        _rarity: Array | Number,
        _topics: Array | Number,
        rarityImages: Array | Number,
    },
    data: function() {
        return {
            valid: false,
            showPassword: false,
            tab: null,
            dialog: false,
            dialogState: "none", // "loading" || "success" || "failure" || "confirm" || "none"
            dialogAction: "none", // "create" || "edit" || "delete" || "none"
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
                {
                    id: 0,
                    rarityId: null,
                    rarity: 0,
                    rarityName: "ノーマル",
                    probability: 50,
                    rarityImageId: "01E02KJWM2PHQT336MOP065X01",
                },
                {
                    id: 1,
                    rarityId: null,
                    rarity: 1,
                    rarityName: "シルバー",
                    probability: 35,
                    rarityImageId: "01E02KJWM2PHQT336MOP065X02",
                },
                {
                    id: 2,
                    rarityId: null,
                    rarity: 2,
                    rarityName: "ゴールド",
                    probability: 13,
                    rarityImageId: "01E02KJWM2PHQT336MOP065X03",
                },
                {
                    id: 3,
                    rarityId: null,
                    rarity: 3,
                    rarityName: "プラチナ",
                    probability: 2,
                    rarityImageId: "01E02KJWM2PHQT336MOP065X04",
                },
            ],
            rarityCount: 4,
            removedRarities: [],
            topics: {},
            removedTopics: [],
            topicCount: 0,
            rules: {
                gachaName: [
                    v => !!v || "タイトルは必須です",
                    v => v === null || v.length <= 50 || "タイトルは50文字以内で入力してください",
                ],
                description: [v => v === null || v.length <= 500 || "説明は500文字以内で入力してください"],
                password: [v => v === null || v.length <= 16 || "パスワードは16文字以内で入力してください"],
                needPassword: [
                    v => !!v || "使用、編集、削除にロックをかける場合は、パスワードが必須です",
                    v => v === null || v.length <= 16 || "パスワードは16文字以内で入力してください",
                ],
                topic: [
                    v => !!v || "お題には1文字以上入力してください",
                    v => v === null || v.length <= 30 || "お題は30文字以内で入力してください",
                ],
            },
            topicsError: "",
        };
    },
    computed: {
        topicLength: function() {
            let count = 0;
            for (const key of Object.keys(this.topics)) {
                count += this.topics[key].length;
            }
            return count;
        },
        needPass: function() {
            return this.gacha.needUsePass || this.gacha.needEditPass || this.gacha.needDeletePass;
        },
        isEdit: function() {
            return !!this._gacha && !!this._rarity && !!this._topics;
        },
        rarityImageMap() {
            const pair = this.rarityImages.map(obj => [obj.rarity_image_id, obj.rarity_image_path]);
            return new Map(pair);
        },
        images() {
            return this.rarities.map(r => this.rarityImageMap.get(r.rarityImageId));
        },
    },
    watch: {
        "gacha.needUsePass": function(value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        "gacha.needEditPass": function(value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        "gacha.needDeletePass": function(value, oldValue) {
            if (!this.needPass) {
                this.gacha.password = null;
            }
        },
        topics: {
            handler: function(val, oldValue) {
                let count = [];
                let totalCount = 0;
                for (const key of Object.keys(this.topics)) {
                    if (count.key === undefined) {
                        count[key] = 0;
                    }
                    count[key] += this.topics[key].length;
                    totalCount += this.topics[key].length;
                }
                for (const key of Object.keys(this.topics)) {
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
            deep: true,
        },
    },
    mounted() {
        // トピックの初期化
        for (const rarity of this.rarities) {
            this.$set(this.topics, rarity.id, []);
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
            };
            this.rarities = [];
            console.log(this._rarity);
            for (const rarity of this._rarity) {
                this.rarities.push(
                    this.createRarity(
                        rarity.rarity_id,
                        rarity.rarity_name,
                        Math.floor(rarity.probability / 10),
                        rarity.rarity_image_id,
                    ),
                );
            }
            const mapRarityIdToId = new Map(
                this.rarities.map(r => {
                    return [r.rarityId, r.id];
                }),
            );
            console.log(this.rarities);
            console.log(mapRarityIdToId);
            console.log(this._topics);
            this.topics = {};
            for (const rarity of this.rarities) {
                this.$set(this.topics, rarity.id, []);
            }
            for (const topic of this._topics) {
                this.topics[mapRarityIdToId.get(topic.rarity_id)].push(this.Topic(topic.topic, topic.topic_id));
            }
        } else {
            for (const rarity of this.rarities) {
                this.topics[rarity.id].push(this.Topic());
            }
        }
    },
    methods: {
        createRarity(rarityId = null, rarityName = "", probability = "", rarityImageId = null) {
            return {
                id: this.rarityCount++,
                rarityId: rarityId,
                rarity: 0,
                rarityName,
                probability,
                rarityImageId,
            };
        },
        addRarity() {
            let lastRarity;
            let index = 0;
            for (const rarity of this.rarities) {
                if (rarity.probability > 0) {
                    lastRarity = rarity;
                    break;
                }
                index++;
            }
            this.updateProbability(index, lastRarity.probability - 1);
            this.rarities.push(this.createRarity(null, "", 1, "01E02KJWM2PHQT336MOP065X01"));
        },
        removeRarity(index) {
            const removed = this.rarities.splice(index, 1)[0];
            if (removed.rarityId !== null) {
                this.removedRarities.push(removed);
            }
            delete this.topics[removed.id];
        },
        updateRarityName(index, rarityName) {
            this.rarities[index].rarityName = rarityName;
        },
        updateRarityImage(index, rarityImageId) {
            this.rarities[index].rarityImageId = rarityImageId;
        },
        updateProbability(index, probability) {
            this.rarities[index].probability = probability;
        },
        Topic(value = "", topicId = null) {
            return { value, id: this.topicCount++, topicId };
        },
        addTopic() {
            const rarityId = this.rarities[this.tab].id;
            if (!this.topics[rarityId]) {
                this.$set(this.topics, rarityId, []);
            }
            this.topics[rarityId].push(this.Topic());
        },
        removeTopic(index) {
            const rarityId = this.rarities[this.tab].id;
            const removed = this.topics[rarityId].splice(index, 1)[0];
            if (removed.topicId !== null) {
                this.removedTopics.push(removed);
            }
        },
        changeTopicRarity(index, id) {
            const rarityId = this.rarities[this.tab].id;
            const moveTopic = this.topics[rarityId].splice(index, 1)[0];
            this.topics[id].push(moveTopic);
        },
        onTopicUpdated(value, index, rarityId, id, topicId) {
            this.topics[rarityId][index] = { value, id, topicId };
            // 以下バリデーション
            for (const key of Object.keys(this.topics)) {
                for (const topic of this.topics[key]) {
                    if (topic.value === null || topic.value.length < 1 || topic.value.length > 30) {
                        this.topicsError = "お題は1〜30文字で入力してください";
                        return;
                    }
                }
            }
            this.topicsError = "";
        },
        async onSubmit() {
            this.dialogState = "loading";
            this.dialogAction = this.isEdit ? "edit" : "create";
            this.dialog = true;
            const sortedRarities = this.rarities.sort((a, b) => b.probability - a.probability);
            const rarities = sortedRarities.map((r, index) => ({ ...r, rarity: index }));
            const idRarityMap = new Map(rarities.map(r => [`${r.id}`, r.rarity]));
            const topics = [];
            for (const id of Object.keys(this.topics)) {
                const _topics = this.topics[id];
                for (const topic of _topics) {
                    if (!topic.value) {
                        continue;
                    }
                    topics.push({
                        topicId: topic.topicId,
                        topic: topic.value,
                        rarity: idRarityMap.get(id),
                    });
                }
            }
            const request = {
                gacha: this.gacha,
                rarity: rarities,
                topics: topics,
                removedTopics: this.removedTopics,
                removedRarities: this.removedRarities,
            };
            console.log(request);
            const method = this.isEdit
                ? axios.put(`/gacha/${this._gacha.gacha_id}`, request)
                : axios.post(`/gacha`, request);
            return await method
                .then(res => {
                    this.dialogState = "success";
                })
                .catch(error => {
                    this.dialogState = "failure";
                    // console.log(error.response.data.errors);
                });
        },
        onDeleteButton() {
            if (this._gacha.needDeletePass) {
                this.showPasswordDialog = true;
            } else {
                this.dialogState = "confirm";
                this.dialogAction = "delete";
                this.dialog = true;
            }
        },
        onDeleteConfirm(confirm) {
            if (confirm) {
                this.deleteGacha();
            } else {
                this.resetPasswordDialog();
                this.dialog = false;
            }
        },
        async deleteGacha() {
            this.dialogState = "loading";
            this.dialogAction = "delete";
            this.dialog = true;
            await axios
                .delete(`/gacha/${this._gacha.gacha_id}`, {})
                .then(res => {
                    this.dialogState = "success";
                })
                .catch(error => {
                    this.dialogState = "failure";
                    // console.log(error.response.data.errors);
                });
        },
        async onPasswordConfirm(password) {
            const request = { password, type: 2 };
            return await axios
                .post(`/api/gacha/${this._gacha.gacha_id}/auth`, request)
                .then(res => {
                    this.showPasswordDialog = false;
                    this.dialogState = "confirm";
                    this.dialogAction = "delete";
                    this.dialog = true;
                    return true;
                })
                .catch(error => {
                    return false;
                });
        },
        setResetPasswordDialog(event) {
            this.resetPasswordDialog = event;
        },
        moveTopPage() {
            window.location.href = `/gacha`;
        },
    },
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
.percentage-box {
    height: 40px;
    width: 64px;
    border-radius: 4px;
    border: solid 1px #aeaeae;
    color: #757575;
}
.v-list-item__title {
    font-size: 0.9rem !important;
}
.topic-list-enter-active,
.topic-list-leave-active {
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
.rarity-image-selection-hover {
    background-color: #eeeeee;
}
.rarity-image-selection-selected {
    opacity: 0.3;
}
</style>
