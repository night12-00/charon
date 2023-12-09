/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_CHARON_ENV: 'demo' | undefined
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
