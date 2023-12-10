<template>
  <form :class="{ error: failed }" data-testid="register-form" @submit.prevent="register">
    <div class="logo">
      <img alt="Charon's logo" src="@/../img/logo.png" width="156">
    </div>
    <input v-model="fullName" autofocus placeholder="Full Name" required type="text">
    <input v-model="email" autofocus placeholder="Email Address" required type="email">
    <input v-model="password" placeholder="Password" required type="password">
    <input v-model="rePassword" placeholder="Confirm Password" required type="password">
    <Btn type="submit">Create Account</Btn>
    <p class="register">Already have an account? <a @click="goLogin">Login</a></p>
  </form>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { userStore } from '@/stores'
import Btn from '@/components/ui/Btn.vue'

const DEFAULT= {
  fullName: '',
  email: '',
  password: '',
  rePassword: ''

}

const url = ref('')
const fullName = ref(DEFAULT.fullName)
const email = ref(DEFAULT.email)
const password= ref(DEFAULT.password)
const rePassword = ref(DEFAULT.rePassword)
const failed = ref(false)

const emit = defineEmits<{ (e: 'registeredin'): void , (e: 'toggleIsLogin'):void }>()


const goLogin = () => {
  emit('toggleIsLogin')
}
const register = async () => {
  try {
    await userStore.register(fullName.value, email.value, password.value, rePassword.value)
    failed.value = false
    // Reset the password so that the next login will have this field empty.
    password.value = ''
    rePassword.value = ''
    emit('registeredin')
  } catch (err) {
    failed.value = true
    window.setTimeout(() => (failed.value = false), 2000)
  }
}
</script>

<style lang="scss" scoped>
/**
 * I like to move it move it
 * I like to move it move it
 * I like to move it move it
 * You like to - move it!
 */
@keyframes shake {
  8%, 41% {
    transform: translateX(-10px);
  }
  25%, 58% {
    transform: translateX(10px);
  }
  75% {
    transform: translateX(-5px);
  }
  92% {
    transform: translateX(5px);
  }
  0%, 100% {
    transform: translateX(0);
  }
}

form {
  width: 280px;
  padding: 1.8rem;
  background: rgba(255, 255, 255, .08);
  border-radius: .6rem;
  border: 1px solid transparent;
  transition: .5s;
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &.error {
    border-color: var(--color-red);
    animation: shake .5s;
  }

  .logo {
    text-align: center;
  }
  .register{
    text-align: center;
  }


  @media only screen and (max-width: 414px) {
    border: 0;
    background: transparent;
  }
}
</style>
