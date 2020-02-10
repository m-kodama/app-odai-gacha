<template>
    <v-text-field
        :value="value"
        @input="$emit('input', $event.target.value)"
        :append-icon="appendIcon"
        @click:append="clickAppend()"
        :clearable="clearable"
        :color="color"
        :dense="dense"
        :disabled="disabled"
        :flat="flat"
        :hide-details="hideDetails"
        :label="label"
        :outlined="outlined"
        :placeholder="placeholder"
        :prefix="prefix"
        :readonly="readonly"
        :solo="solo"
        :suffix="suffix"
        :type="type"
    ></v-text-field>
</template>

<script>
export default {
    props: {
        value: String,
        appendIcon: {
            type: String,
            default: undefined
        },
        clickAppend: {
            type: Function,
            default: () => {}
        },
        clearable: {
            type: Boolean,
            default: true
        },
        color: {
            type: String,
            default: "accent"
        },
        dense: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        flat: {
            type: Boolean,
            default: true
        },
        hideDetails: {
            type: Boolean | String,
            default: true
        },
        label: {
            type: String,
            default: undefined
        },
        outlined: {
            type: Boolean,
            default: true
        },
        placeholder: {
            type: String,
            default: undefined
        },
        prefix: {
            type: String,
            default: undefined
        },
        readonly: {
            type: Boolean,
            default: false
        },
        solo: {
            type: Boolean,
            default: true
        },
        suffix: {
            type: String,
            default: undefined
        },
        type: {
            type: String,
            default: "text"
        },
    }
};
</script>

<style scoped></style>
