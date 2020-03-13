<template>
    <v-card outlined class="pa-4">
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
            @change="onChange"
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
            default: () => ["egg_06.png", "egg_08.png", "egg_12.png"],
        },
        percentages: {
            type: Array,
            default: () => [500, 350, 150],
        },
    },
    data: function() {
        return {
            process: dotsPos => {
                const array = [];
                if (dotsPos.length < 1) {
                    return array;
                }
                const color = "#40BFC1";
                array[0] = [0, dotsPos[0], { backgroundColor: color }];
                for (var i = 1; i < dotsPos.length; i++) {
                    array[i] = [dotsPos[i - 1], dotsPos[i], { backgroundColor: color }];
                }
                array[dotsPos.length] = [dotsPos[dotsPos.length - 1], 100, { backgroundColor: color, disabled: true }];
                return array;
            },
        };
    },
    computed: {
        dots: {
            get() {
                const data = this.percentages.map(p => Math.floor(p / 10)).slice(0, -1);
                const dots = [];
                if (data.length === 0) {
                    return dots;
                }
                let total = 0;
                for (const percentage of data) {
                    total += percentage;
                    dots.push(total);
                }
                return dots;
            },
            set(value) {
                this.$emit("change", value);
            },
        },
    },
    methods: {
        add: function() {
            this.images.push("item_" + this.images.length);
            this.setDots();
        },
        remove: function() {
            this.images.pop();
            this.setDots();
        },
        setDots: function() {
            this.dots = [];
            if (this.images.length > 1) {
                var x = 100 / this.images.length;
                for (var i = 0; i < this.images.length - 1; i++) {
                    this.dots.push(Math.floor(x * (i + 1)));
                }
                this.$refs.slider.setValue(this.dots);
            }
        },
        getPercentage: function(index) {
            if (this.images.length == 1) {
                return 100;
            } else if (index == 0) {
                return Array.isArray(this.dots) ? this.dots[0] : this.dots;
            } else if (index == this.images.length - 1) {
                return 100 - (Array.isArray(this.dots) ? this.dots[index - 1] : this.dots);
            }

            return this.dots[index] - this.dots[index - 1];
        },
        onChange(value) {
            console.log(value, this.dots);
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
.vue-slider-dot {
    width: 25px !important;
    height: 25px !important;
}
</style>
