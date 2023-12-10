import { differenceBy, merge } from 'lodash'
import { http } from '@/services'
import { reactive } from 'vue'
import { arrayify } from '@/utils'
import { UnwrapNestedRefs } from '@vue/reactivity'

export interface UpdateCurrentProfileData {
  current_password: string | null
  name: string
  email: string
  avatar?: string
  new_password?: string
}

interface UserFormData {
  name: string
  email: string
  is_admin: boolean
}

export interface CreateUserData extends UserFormData {
  password: string
}

export interface UpdateUserData extends UserFormData {
  password?: string
}

export const userStore = {
  vault: new Map<number, UnwrapNestedRefs<User>>(),

  state: reactive({
    users: [] as User[],
    current: null as unknown as User
  }),

  syncWithVault (users: User | User[]) {
    return arrayify(users).map(user => {
      let local = this.byId(user.id)
      local = reactive(local ? merge(local, user) : user)
      this.vault.set(user.id, local)

      return local
    })
  },

  init (currentUser: User) {
    this.state.users = this.syncWithVault(currentUser)
    this.state.current = this.state.users[0]
  },

  async fetch () {
    this.state.users = this.syncWithVault(await http.get<User[]>('users'))
  },

  byId (id: number) {
    return this.vault.get(id)
  },

  get current () {
    return this.state.current
  },

  login: async (email: string, password: string) => await http.post<User>('me', { email, password }),
  register: async (fullName: string, email: string, password:string, rePassword: string) => await http.post<User>('register', {fullName, email, password, rePassword}),
  logout: async () => await http.delete('me'),
  getProfile: async () => await http.get<User>('me'),

  async updateProfile (data: UpdateCurrentProfileData) {
    merge(this.current, (await http.put<User>('me', data)))
  },

  async store (data: CreateUserData) {
    const user = await http.post<User>('users', data)
    this.state.users.push(...this.syncWithVault(user))
    return this.byId(user.id)
  },

  async update (user: User, data: UpdateUserData) {
    this.syncWithVault(await http.put<User>(`users/${user.id}`, data))
  },

  async destroy (user: User) {
    await http.delete(`users/${user.id}`)
    this.state.users = differenceBy(this.state.users, [user], 'id')
    this.vault.delete(user.id)


  }
}
