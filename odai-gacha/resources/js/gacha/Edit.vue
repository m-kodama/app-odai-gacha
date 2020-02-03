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
                                    <div
                                        style="border-radius: 4px; background:rgba(0,0,0,.12); height: 100%; width:100%; user-select:none;"
                                        class="d-flex flex-column justify-center align-center"
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
                                </div>
                            </div>
                            <!-- レア度 -->
                            <div class="mb-8">
                                <div class="form-title">レア度</div>
                                <div class="d-flex align-center mb-4">
                                    <TextField
                                        class="flex-grow-1 mr-2"
                                        dense
                                        label="レア度の名前"
                                        disabled
                                        value="ノーマル"
                                    />
                                    <div class="mr-4" style="width:80px;">
                                        <TextField
                                            dense
                                            label="確率"
                                            suffix="%"
                                            type="number"
                                            disabled
                                            :value="50"
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
                            <!-- お題 -->
                            <div class="mb-8">
                                <div class="form-title">お題</div>
                                <v-tabs class="mb-2" height="40">
                                    <v-tab>ノーマル</v-tab>
                                    <v-tab>シルバー</v-tab>
                                    <v-tab>ゴールド</v-tab>
                                    <v-tab>プラチナ</v-tab>
                                </v-tabs>
                                <div class="d-flex align-center mb-4">
                                    <TextField
                                        class="flex-grow-1 mr-2"
                                        dense
                                        label="ガチャを回した時に出る「お題」を入力してください"
                                    />
                                    <div
                                        class="square-button mr-4 d-flex align-center justify-center"
                                        v-ripple
                                    >
                                        <v-icon color="grey darken-1"
                                            >mdi-arrow-right</v-icon
                                        >
                                    </div>
                                    <v-btn
                                        depressed
                                        color="#eeeeee"
                                        class="px-4"
                                    >
                                        <v-icon color="grey darken-1"
                                            >mdi-delete-forever</v-icon
                                        >
                                    </v-btn>
                                </div>
                                <div class="d-flex justify-center">
                                    <v-btn
                                        style="width: 50% !important; min-width: 120px; color: #333;"
                                        color="secondary"
                                        rounded
                                        depressed
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
            showPassword: false,
            gacha: {
                needUsePass: false,
                needEditPass: true,
                needDeletePass: true
            }
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
    methods: {
        onSubmit() {}
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
</style>
