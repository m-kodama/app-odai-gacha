<template>
    <div>
        <PercentageSlider title="排出率" class="mb-2"></PercentageSlider>
        <template v-for="(rarity, index) in rarities">
            <div class="d-flex align-center mb-2" :key="rarity.key">
                <v-menu
                    transition="scale-transition"
                    origin="center center"
                    :nudge-left="nudgeLeft"
                    :nudge-top="nudgeTop"
                >
                    <template v-slot:activator="{ on }">
                        <div class="square-button mr-2 d-flex align-center justify-center pa-1" v-ripple v-on="on">
                            <v-img
                                :src="`/img/${rarityIdToPath.get(rarity.rarityImageId)}`"
                                aspect-ratio="1"
                                contain
                                v-if="rarity.rarityImageId !== null"
                            ></v-img>
                        </div>
                    </template>
                    <v-card class="d-flex align-center justify-start flex-wrap pa-2" :width="rarityImageDialogWidth">
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
                                        rarityImage.rarity_image_id === rarity.rarityImageId,
                                }"
                                v-ripple
                                @click="updateRarityImage(index, rarityImage.rarity_image_id)"
                                :style="`width: ${rarityImageButtonSize}px; height: ${rarityImageButtonSize}px;`"
                                style="border-radius: 4px; cursor: pointer;"
                            >
                                <v-img :src="`/img/${rarityImage.rarity_image_path}`" aspect-ratio="1" contain></v-img>
                            </div>
                        </v-hover>
                    </v-card>
                </v-menu>
                <TextField
                    class="flex-grow-1 mr-2"
                    dense
                    label="レア度の名称"
                    :value="rarity.rarityName"
                    @change="
                        value => {
                            updateRarityName(index, value);
                        }
                    "
                />
                <div class="mr-4" style="width:50px;">{{ rarity.probability }} %</div>
                <v-btn depressed color="#eeeeee" class="px-4" @click="removeRarity(index)">
                    <v-icon color="grey darken-1">mdi-delete-forever</v-icon>
                </v-btn>
            </div>
        </template>
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
</template>

<script>
import TextField from "../components/TextField";
import PercentageSlider from "../components/PercentageSlider";

export default {
    components: {
        TextField,
        PercentageSlider,
    },
    props: {
        rarity: {
            type: Array | Number,
            required: true,
        },
        rarityImages: {
            type: Array | Number,
            required: true,
        },
        _rarities: {
            type: Array,
            required: true,
        },
        _removedRarities: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            count: 0,
        };
    },
    computed: {
        initialRarities: () => [
            ["ノーマル", 50, "01E02KJWM2PHQT336MOP065X01"],
            ["シルバー", 35, "01E02KJWM2PHQT336MOP065X02"],
            ["ゴールド", 13, "01E02KJWM2PHQT336MOP065X03"],
            ["ノーマル", 2, "01E02KJWM2PHQT336MOP065X04"],
        ],
        rarityImageButtonArea: () => 40,
        rarityImageButtonPadding: () => 8,
        rarityImageButtonSize() {
            return this.rarityImageButtonArea + this.rarityImageButtonPadding;
        },
        rarityIdToPath() {
            const pair = this.rarityImages.map(obj => [obj.rarity_image_id, obj.rarity_image_path]);
            return new Map(pair);
        },
        nudgeLeft() {
            return (
                (this.rarityImageButtonSize * 4 + this.rarityImageButtonPadding * 2 - this.rarityImageButtonArea) / 2
            );
        },
        nudgeTop() {
            return (
                (this.rarityImageButtonSize * 3 + this.rarityImageButtonPadding * 2 - this.rarityImageButtonArea) / 2
            );
        },
        rarityImageDialogWidth() {
            return this.rarityImageButtonSize * 4 + this.rarityImageButtonPadding * 2;
        },
    },
    mounted() {
        // console.log("--- RarityForm.vue ---");
        // console.log(this.rarity);
        // console.log(this.rarityImages);
        if (this.rarity) {
            this.rarities = this.rarity.map(r =>
                this.createRarity(r.rarity_name, Math.floor(r.probability / 10), r.rarity_image_id, r.rarity_id),
            );
        } else {
            this.rarities = this.initialRarities.map(r => {
                const [rarityName, probability, rarityImageId] = r;
                return this.createRarity(rarityName, probability, rarityImageId);
            });
        }
    },
    methods: {
        createRarity(rarityName = "", probability = "", rarityImageId = null, rarityId = null) {
            return {
                key: this.count++,
                rarityId: rarityId,
                rarity: 0,
                rarityName,
                probability,
                rarityImageId,
            };
        },
        addRarity() {
            this.rarities.push(this.createRarity("", 1, "01E02KJWM2PHQT336MOP065X01"));
        },
        removeRarity(index) {
            const removed = this.rarities.splice(index, 1)[0];
            if (removed.rarityId !== null) {
                this.removedRarities.push(removed);
            }
            delete this.topics[removed.key];
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
    },
};
</script>

<style scoped>
.rarity-image-selection-hover {
    background-color: #eeeeee;
}
.rarity-image-selection-selected {
    opacity: 0.3;
}
</style>
