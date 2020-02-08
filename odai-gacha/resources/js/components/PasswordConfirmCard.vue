<template>
    <v-card outlined class="pa-10 d-flex flex-column align-center justify-center">
      <div style="padding: 32px 0 64px 0;" class="d-flex flex-column align-center justify-center">
        <v-icon color="primary" size="48" class="mb-2">mdi-lock-outline</v-icon>
        <span class="primary--text" style="font-weight:700; font-size:1.2rem;">ロックされています</span>
      </div>
      <div class="error--text mb-2" :class="{hidden: isSuccess}">パスワードが違います。</div>
      <div class="d-flex" style="width:100%;">
        <v-text-field
          class="mb-4 flex-grow-1"
          color="accent"
          outlined
          solo
          flat
          label="パスワード"
          clearable
          hide-details
          type="password"
          v-model="password"
        ></v-text-field>
      </div>
      <v-btn
          style="width: 200px !important;"
          depressed
          color="accent"
          large
          @click="onTap"
          :loading="loading"
      >
        解除
      </v-btn>
    </v-card>
</template>

<script>
export default {
  props: {
      onSubmit: {
        type: Function,
        default: async () => {}
      }
    },
    data: function() {
        return {
            password: "",
            loading: false,
            isSuccess: true,
        };
    },
    mounted() {
      this.$emit('reset-event', this.reset);
    },
    methods: {
        async onTap() {
          this.loading = true;
          this.isSuccess = await this.onSubmit(this.password);
          console.log("aaa: " + this.isSuccess);
          this.loading = false;
        },
        reset() {
          this.password = "";
          this.isSuccess = true;
          this.loading = false;
        }
    }
};
</script>

<style scoped>
.hidden {
  visibility: hidden;
}
</style>
