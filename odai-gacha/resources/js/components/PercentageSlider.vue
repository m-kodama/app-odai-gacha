<template>
    <v-card outlined class="px-4 pt-4 pb-6">
        <div class="header">{{ title }}</div>
        <vue-slider
            ref="slider"
            v-model="dots"
            tooltip="none"
            :process="process"
            :enable-cross="false"
            :min-range="1"
            :min="1"
            :duration="0.2"
        >
            <template v-slot:process="{ start, end, style, index }">
                <div class="vue-slider-process" :style="style">
                    <div :class="['merge-tooltip', 'vue-slider-dot-tooltip-inner', 'vue-slider-dot-tooltip-inner-top']">
                        <v-img :src="`/img/${images[index]}`" aspect-ratio="1" contain class="image"></v-img>
                        {{ getPercentage(index) }}%
                    </div>
                </div>
            </template>
        </vue-slider>
    </v-card>
</template>

<script>
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";

export default {
    components: {
        VueSlider,
    },
    props: {
        title: {
            type: String,
            default: "",
        },
        images: {
            type: Array,
            required: true,
        },
        rarities: {
            type: Array,
            required: true,
        },
    },
    data: function() {
        return {
            process: dotsPos => {
                console.log("dotsPos", dotsPos);
                const colorStyle = { backgroundColor: "#40BFC1" };
                if (dotsPos.length === 0) {
                    return [0, 100, colorStyle];
                }
                const process = [[0, dotsPos[0], colorStyle]];
                for (let i = 1, n = dotsPos.length; i < n; i++) {
                    process.push([dotsPos[i - 1], dotsPos[i], colorStyle]);
                }
                process.push([dotsPos[dotsPos.length - 1], 100, colorStyle]);
                return process;
            },
        };
    },
    // watch: {
    //     // この関数は question が変わるごとに実行されます。
    //     dots: function(newValue, oldValue) {
    //         if (oldValue && newValue.length !== oldValue.length) {
    //             console.log(1, newValue);
    //             this.$refs.slider.setValue(newValue);
    //         }
    //     },
    // },
    computed: {
        percentages() {
            return this.rarities.map(r => r.probability);
        },
        dots: {
            get() {
                if (this.percentages.length === 0) {
                    return [];
                }
                const dots = [];
                let total = 0;
                const ret = this.percentages.slice(0, -1).map(p => (total += p));
                console.log("dots.get", ret);
                return ret;
            },
            set(value) {
                console.log("value", value);
                const dots = Array.isArray(value) ? value : [value];
                const percentages = [dots[0]];
                for (let i = 1, n = dots.length; i < n; i++) {
                    percentages.push(dots[i] - dots[i - 1]);
                }
                percentages.push(100 - dots[dots.length - 1]);
                console.log("dots.set", percentages);
                this.$emit("change", percentages);
            },
        },
    },
    methods: {
        getPercentage: function(index) {
            return this.percentages[index];
        },
    },
};
</script>

<style scoped>
.header {
    font-size: 0.9rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 56px;
}
.image {
    width: 24px !important;
    height: 24px !important;
    margin: 0 2px 0 0;
}
.merge-tooltip {
    display: flex;
    line-height: 24px;
    position: absolute;
    left: 50%;
    bottom: 100%;
    transform: translate(-50%, -15px);
    white-space: nowrap;
    color: #fff;
    background-color: inherit;
    padding: 4px 12px 4px 8px;
    border-radius: 30px;
    border-top-color: #40bfc1;
}
</style>

<style>
.vue-slider-dot-handle {
    width: 8px !important;
    height: 40px !important;
    cursor: col-resize !important;
    border-radius: 4px !important;
    border: none !important;
    background-color: #40bfc1 !important;
    transform: translate(0, -15px) !important;
}
</style>
