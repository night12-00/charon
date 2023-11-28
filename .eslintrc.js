module.exports = {
  env: { 'browser': true, 'es2022': true, 'node': true },
  extends: [
    "plugin:vue/base",
    "plugin:vue/vue3-recommended",
    "prettier"
  ],
  parser: "vue-eslint-parser",
  parserOptions: {
    'ecmaVersion': 'latest',
    'sourceType': 'module'
  },
  settings: { 'vue': { 'version': '3.2' } },

  ignorePatterns: [
    "cypress/fixtures",
    "cypress/screenshots",
    "resources/assets/js/tests/__coverage__"
  ],
  globals: {
    "FileReader": "readonly",
    "defineProps": "readonly",
    "defineEmits": "readonly",
    "defineExpose": "readonly",
    "withDefaults": "readonly"
  },
  rules: {
    "no-multi-str": 0,
    "no-empty": 0,
    'no-console': 1,
    'no-lonely-if': 1,
    'no-unused-vars': 1,
    'no-trailing-spaces': 1,
    'no-multi-spaces': 1,
    'no-multiple-empty-lines': 1,
    'space-before-blocks': ['error', 'always'],
    'object-curly-spacing': [1, 'always'],
    'indent': ['warn', 2],
    'semi': [1, 'never'],
    'quotes': ['error', 'single'],
    'array-bracket-spacing': 1,
    'linebreak-style': 0,
    'no-unexpected-multiline': 'warn',
    'keyword-spacing': 1,
    'comma-dangle': 1,
    'comma-spacing': 1,
    'arrow-spacing': 1,
    "no-use-before-define": 0,
    "@typescript-eslint/no-var-requires": 0,
    "@typescript-eslint/member-delimiter-style": 0,
    "@typescript-eslint/consistent-type-assertions": 0,
    "@typescript-eslint/no-inferrable-types": 0,
    "@typescript-eslint/no-explicit-any": 0,
    "@typescript-eslint/no-non-null-assertion": 0,
    "@typescript-eslint/ban-ts-comment": 0,
    "@typescript-eslint/no-empty-function": 0,
    "@typescript-eslint/explicit-module-boundary-types": 0,
    "standard/no-callback-literal": 0,
    "vue/valid-v-on": 0,
    "vue/no-side-effects-in-computed-properties": 0,
    "vue/max-attributes-per-line": 0,
    "vue/no-v-html": 0,
    "vue/singleline-html-element-content-newline": 0,
    "vue/multi-word-component-names": 0,
    'prettier/prettier': [
      'warn',
      {
        'arrowParens': 'always',
        'semi': false,
        'trailingComma': 'none',
        'tabWidth': 2,
        'endOfLine': 'auto',
        'useTabs': false,
        'singleQuote': true,
        'printWidth': 80,
        'jsxSingleQuote': true
      }
    ]
  }

}
