<template>
    <v-dialog :value="value" v-on:input="$emit('input', $event)" v-bind="$attrs" max-width="500px">
        <v-card>
            <v-card-title class="text-h5">
                <slot></slot>
            </v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="onCancel">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="onOk">OK</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        onCancel() {
            this.$emit('input', false);
        },
        onOk() {
            this.$emit('input', true); // Or emit a different event if needed
        },
    },
};
</script>
