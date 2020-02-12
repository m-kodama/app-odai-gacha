<template>
    <v-card outlined class="pa-10 d-flex flex-column align-center justify-center">
      <div v-if="isSuccess" style="padding: 32px 0 48px 0;" class="d-flex flex-column align-center justify-center">
        <v-icon color="accent" size="48" class="mb-2 lock-icon">mdi-lock-open-variant-outline</v-icon>
        <span class="accent--text" style="font-weight:700; font-size:1.2rem;">ロックを解除しました</span>
      </div>
      <div v-else style="padding: 32px 0 48px 0;" class="d-flex flex-column align-center justify-center">
        <v-icon color="primary" size="48" class="mb-2 lock-icon" :class="{vibration: isVibration}">mdi-lock-outline</v-icon>
        <span class="primary--text" style="font-weight:700; font-size:1.2rem;">ロックされています</span>
      </div>
      <div class="error--text mb-2" :class="{hidden: isHiddenErrorMesssage}">パスワードが違います。</div>
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
          :disabled="loading"
        ></v-text-field>
      </div>
      <v-btn
          style="width: 200px !important; transition: all 0.2s ease-in-out"
          depressed
          color="accent"
          large
          @click="onTap"
          :loading="loading"
          :disabled="!password"
      >
        <template v-if="isSuccess">
          <v-icon color="white" size="24">mdi-check</v-icon>
        </template>
        <template v-else>
          <span>解除</span>
        </template>
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
            isSuccess: null,
            isVibration: false,
        };
    },
    computed: {
        isHiddenErrorMesssage: function() {
            return this.isSuccess || this.isSuccess === null
        },
    },
    mounted() {
      this.$emit('reset-event', this.reset);
    },
    methods: {
        async onTap() {
          this.loading = true;
          this.isSuccess = await this.onSubmit(this.password);
          this.loading = false;
          if (!this.isSuccess) {
            this.isVibration = true;
            await new Promise(r => setTimeout(r, 200));
            this.isVibration = false;
          }
        },
        reset() {
          this.password = "";
          this.isSuccess = null;
          this.loading = false;
        }
    }
};
</script>

<style scoped>
.hidden {
  visibility: hidden;
}
.vibration {
  animation: vibration 0.2s ease 0s 1 normal none running;
}
@keyframes vibration {
  0% {
    transform: translateX(0px);;
  }
  33% {
    transform: translateX(10px);
  }
  66% {
    transform: translateX(-8px);
  }
  100% {
    transform: translateX(4px);
  }
}
</style>
