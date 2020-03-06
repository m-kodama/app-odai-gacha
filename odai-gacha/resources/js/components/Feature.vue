<template>
    <div class="d-flex flex-column align-center">
        <v-icon color="primary" size="48">{{ icon }}</v-icon>
        <div class="title-text my-2">
            {{ title }}
        </div>
        <div class="text">
            {{ text }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        title: String,
        text: String,
    },
};
</script>

<style scoped>
.title-text {
    font-size: 1.3rem;
    color: #333;
    font-weight: 700;
}
.text {
    color: #757575;
    font-size: 0.8rem;
    text-align: center;
    width: 80%;
}
</style>
