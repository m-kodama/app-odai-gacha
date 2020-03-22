<template>
    <v-dialog v-model="_show" persistent max-width="380">
        <v-card style="height: 350px; padding: 32px;" class="d-flex flex-column align-center justify-center">
            <!-- ロード中 -->
            <template v-if="state === 'loading'">
                <div class="mb-10">
                    <v-progress-circular :size="64" :width="7" color="accent" indeterminate></v-progress-circular>
                </div>
                <div class="dialog-message mt-6">
                    <template v-if="action === 'create'">作成中...</template>
                    <template v-if="action === 'edit'">更新中...</template>
                    <template v-if="action === 'delete'">削除中...</template>
                </div>
            </template>
            <!-- 成功 -->
            <template v-if="state === 'success'">
                <div class="mb-10">
                    <v-icon color="accent" size="64" class="mb-2">mdi-check-outline</v-icon>
                </div>
                <div class="dialog-message mt-4">
                    <template v-if="action === 'create'">作成に成功しました</template>
                    <template v-if="action === 'edit'">更新に成功しました</template>
                    <template v-if="action === 'delete'">削除に成功しました</template>
                    <br />
                    <span class="dialog-sub-message">ガチャ一覧ページに移動します</span>
                </div>
                <v-btn class="mt-3" color="accent" depressed @click="onComplete" dense>
                    OK
                </v-btn>
            </template>
            <!-- 失敗 -->
            <template v-if="state === 'failure'">
                <div class="mb-10">
                    <v-icon color="primary" size="64" class="mb-2">mdi-close-outline</v-icon>
                </div>
                <div class="dialog-message mt-4">
                    <template v-if="action === 'create'">作成に失敗しました</template>
                    <template v-if="action === 'edit'">更新に失敗しました</template>
                    <template v-if="action === 'delete'">削除に失敗しました</template>
                    <br />
                    <span class="dialog-sub-message">通信状況を確認してください</span>
                </div>
                <v-btn class="mt-3" color="#eeeeee" depressed @click="_show = false" dense>
                    閉じる
                </v-btn>
            </template>
            <!-- 確認 -->
            <template v-if="state === 'confirm'">
                <div class="mb-10">
                    <v-icon color="primary" size="64" class="mb-2">mdi-delete-alert-outline</v-icon>
                </div>
                <div class="dialog-message mt-4">
                    本当に削除しますか？
                    <br />
                    <span class="dialog-sub-message">削除したガチャは元に戻すことができません</span>
                </div>
                <div class="d-flex align-center justify-center mt-3">
                    <v-btn color="#eeeeee" depressed @click="onConfirm(false)" dense style="width:120px !important;">
                        キャンセル
                    </v-btn>
                    <div style="width:16px;"></div>
                    <v-btn color="primary" depressed @click="onConfirm(true)" dense style="width:120px !important;">
                        削除
                    </v-btn>
                </div>
            </template>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        onComplete: {
            type: Function,
            default: async () => {},
        },
        onConfirm: {
            type: Function,
            default: async confirm => {},
        },
        show: {
            type: Boolean,
            default: false,
        },
        state: {
            type: String, //"loading" || "success" || "failure" || "confirm" || "none",
            default: "none",
        },
        action: {
            type: String, //"create" || "edit" || "delete" || "none",
            default: "none",
        },
    },
    data: function() {
        return {};
    },
    computed: {
        _show: {
            get() {
                return this.$props.show;
            },
            set(value) {
                this.$emit("change", value);
            },
        },
    },
    mounted() {},
    methods: {},
};
</script>

<style scoped>
.dialog-message {
    text-align: center;
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}
.dialog-sub-message {
    font-size: 12px;
    color: #757575;
    font-weight: 400;
}
</style>
