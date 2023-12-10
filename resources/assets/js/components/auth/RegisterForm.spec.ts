import { screen } from '@testing-library/vue'
import { expect, it, Mock } from 'vitest'
import { userStore } from '@/stores'
import UnitTestCase from '@/__tests__/UnitTestCase'
import RegisterForm from './RegisterForm.vue'

new class extends UnitTestCase {
  private async submitForm (loginMock: Mock) {
    const rendered = this.render(RegisterForm)

    await this.type(screen.getByPlaceholderText('Email Address'), 'john@doe.com')
    await this.type(screen.getByPlaceholderText('Password'), 'secret')
    await this.user.click(screen.getByRole('button', { name: 'Log In' }))

    expect(loginMock).toHaveBeenCalledWith('john@doe.com', 'secret')

    return rendered
  }

  protected test () {
    it('renders', () => expect(this.render(RegisterForm).html()).toMatchSnapshot())

    it('logs in', async () => {
      expect((await this.submitForm(this.mock(userStore, 'register'))).emitted().loggedin).toBeTruthy()
    })

    it('fails to log in', async () => {
      const mock = this.mock(userStore, 'register').mockRejectedValue(new Error('Unauthenticated'))
      const { emitted } = await this.submitForm(mock)
      await this.tick()

      expect(emitted().loggedin).toBeFalsy()
      expect(screen.getByTestId('register-form').classList.contains('error')).toBe(true)
    })
  }
}
