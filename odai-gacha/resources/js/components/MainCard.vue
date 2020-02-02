<template>
    <v-card outlined style="height:100%;">
        <v-img
            src="https://picsum.photos/510/300?random"
            lazy-src="../img/default_image.png"
            height="200px"
        >
            <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular
                        indeterminate
                        color="grey lighten-5"
                    ></v-progress-circular>
                </v-row>
            </template>
        </v-img>
        <v-card-title>
            <div class="flex-grow-1">{{ gacha.gacha_name }}</div>
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>mdi-circle-edit-outline</v-icon>
                    </v-btn>
                </template>
                <span>編集</span>
            </v-tooltip>
        </v-card-title>
        <v-card-subtitle>最終編集日：{{ gacha.updated_at }}</v-card-subtitle>
        <div class="card-buttons d-flex">
            <v-btn depressed outlined color="accent" class="flex-grow-1 mr-1"
                >詳細</v-btn
            >
            <v-btn
                depressed
                color="primary"
                class="flex-grow-1 ml-1"
                :href="`./gacha/${gacha.gacha_id}/machine`"
                >起動</v-btn
            >
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
            created_at: Date,
            updated_at: Date
        }
    },
    data: function() {
        return {
            isVisible: true
        };
    },
    computed: {
        gachas: function() {
            return JSON.parse(this._gachas);
        }
    }
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
</style>
