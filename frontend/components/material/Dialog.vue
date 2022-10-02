<template>
    <v-dialog v-model="" v-bind="$attrs" max-width="500px">
        <v-card>
            <v-card-title class="text-h5">
                <slot></slot>
            </v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="">OK</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {

    },
};
</script>