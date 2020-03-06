<template>
    <v-card outlined style="height:100%;">
        <v-img
            :src="`https://picsum.photos/seed/${gacha.gacha_id}/510/300`"
            lazy-src="../img/default_image.png"
            height="200px"
        >
            <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-row>
            </template>
        </v-img>
        <transition name="slide">
            <div class="detail secondary" v-show="showDetail">
                <div class="ma-3">
                    <pre>{{ gacha.description }}</pre>
                </div>
            </div>
        </transition>
        <v-card-title>
            <div class="flex-grow-1">{{ gacha.gacha_name }}</div>
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" @click="onEditButtonTap">
                        <v-icon>mdi-circle-edit-outline</v-icon>
                    </v-btn>
                </template>
                <span>編集</span>
            </v-tooltip>
        </v-card-title>
        <v-card-subtitle>編集日：{{ updated_at }}</v-card-subtitle>
        <div class="card-buttons d-flex">
            <v-btn depressed outlined color="accent" @click="detail" style="width: calc((100% - 8px) / 2);">
                <span v-if="showDetail">閉じる</span><span v-else>詳細</span>
            </v-btn>
            <div style="width: 8px;" />
            <v-btn depressed color="primary" @click="onUseButtonTap" style="width: calc((100% - 8px) / 2);">
                起動
            </v-btn>
        </div>
    </v-card>
</template>

<script>
export default {
    props: {
        gacha: {
            gacha_id: String,
            gacha_name: String,
            image_path: String,
            needUsePass: Boolean,
            needEditPass: Boolean,
            needDeletePass: Boolean,
            created_at: Date,
            updated_at: Date,
        },
        onGachaUseButtonTap: {
            type: Function,
            default: () => {},
        },
        onGachaEditButtonTap: {
            type: Function,
            default: () => {},
        },
    },
    data: function() {
        return {
            isVisible: true,
            showDetail: false,
        };
    },
    computed: {
        updated_at: function() {
            const d = new Date(this.gacha.updated_at);
            const year = d.getFullYear();
            const month = d.getMonth() + 1;
            const day = d.getDate();
            return `${year}年${month}月${day}日`;
        },
    },
    methods: {
        onUseButtonTap() {
            this.onGachaUseButtonTap(this.gacha.gacha_id, this.gacha.needUsePass);
        },
        onEditButtonTap() {
            this.onGachaEditButtonTap(this.gacha.gacha_id, this.gacha.needEditPass);
        },
        detail() {
            this.showDetail = !this.showDetail;
        },
    },
};
</script>

<style scoped>
.card-buttons {
    padding: 0px 16px 16px 16px;
}
.v-card__title {
    font-size: 1rem !important;
    line-height: 1.75rem !important;
    flex-wrap: nowrap;
    align-items: flex-start;
}
.detail {
    position: absolute;
    top: 0px;
    right: 0px;
    height: 200px;
    width: 100%;
    opacity: 0.85;
    font-size: 0.85rem;
    color: #333333;
    overflow-y: scroll;
}
pre {
    white-space: pre-wrap;
}
.slide-enter-active {
    transition: all 0.2s ease-out;
}
.slide-leave-active {
    transition: all 0.3s ease-out;
}
.slide-enter,
.slide-leave-to {
    transform: translateY(20px);
    opacity: 0;
}
</style>
