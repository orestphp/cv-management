<template>
    <v-container fill-height fluid>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-dialog v-model="dialog" width="500">
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">Congratulations !</v-card-title>
                        <v-card-text class="alert-message">Your password is changed now.</v-card-text>
                    </v-card>
                </v-dialog>

                <material-card color="green" title="Edit Profile" text="Change password">
                    <v-form>
                        <v-container class="py-0">
                            <v-row>
                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="password"
                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :rules="[rules.required, rules.min]"
                                        :type="show1 ? 'text' : 'password'"
                                        name="input-10-1"
                                        label="New password"
                                        hint="At least 6 characters"
                                        counter
                                        @click:append="show1 = !show1"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" md="12">
                                    <v-text-field
                                        v-model="password_confirmation"
                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :rules="[rules.required, rules.min, rules.passwordMatch]"
                                        :type="show2 ? 'text' : 'password'"
                                        name="input-10-1"
                                        label="Confirm password"
                                        hint="At least 6 characters"
                                        counter
                                        @click:append="show2 = !show2"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" class="text-right">
                                    <v-btn color="success" @click="updatePassword">Save</v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </material-card>
            </v-col>
            <v-col cols="12" md="4">
                <material-card class="v-card-profile">
                    <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="130">
                        <img src="https://demos.creative-tim.com/vue-material-dashboard/img/marc.aba54d65.jpg" />
                    </v-avatar>
                    <v-card-text class="text-center">
                        <h6 class="overline mb-3">7 Keys to Successful Organizational Development</h6>
                        <p class="font-weight-light">Involve all employees in decision making</p>
                        <p class="font-weight-light">Change should focus on groups and departments</p>
                        <p class="font-weight-light">Build trust throughout the organization</p>
                        <p class="font-weight-light">Encourage collaboration over competition</p>
                        <p class="font-weight-light">Invest in education, benefits and incentives</p>
                        <p class="font-weight-light">Create the opportunity for employee feedback</p>
                        <p class="font-weight-light">Involve all members of the organization</p>
                    </v-card-text>
                </material-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            show1: false,
            show2: false,
            password: 'mypass',
            password_confirmation: 'mypass',
            dialog: false,
            rules: {
                required: (value) => !!value || 'Required.',
                min: (v) => v.length >= 6 || 'Min 6 characters',
                passwordMatch: () =>
                    this.password === this.password_confirmation || `The password you entered don't match`,
            },
        };
    },
    methods: {
        async updatePassword() {
            let self = this;
            if (this.password === this.password_confirmation) {
                await this.$axios.$get('sanctum/csrf-cookie');
                await this.$axios
                    .post('/api/user/update-password', {
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    })
                    .then(function (response) {
                        if (response.data.status === 'success') {
                            self.dialog = true;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            } else {
                return false;
            }
        },
    },
};
</script>

<style scope>
.alert-message {
    margin-top: 25px !important;
}
</style>
