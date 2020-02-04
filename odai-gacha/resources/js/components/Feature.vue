<template>
<div class="d-flex flex-column align-center">
    <v-icon color="primary" size="48">{{ icon }}</v-icon>
    <div class="title my-2">
        {{ title }}
    </div>
    <div class='text'>
        {{ text }}
    </div>
</div>
</template>

<script>
import Header from "../components/Header";
import MainCard from "../components/MainCard";

export default {
    components: {
        Header,
        MainCard
    },
    props: {
        icon: String,
        title: String,
        text: String    
    },
}
 
</script>

<style scoped>
.title {
    font-size: 1.3rem;
    color: #333;
    font-weight: bold;
}
.text {
    color: #757575;
    font-size: 0.8rem;
    text-align: center;
    width: 80%;
}
</style>
