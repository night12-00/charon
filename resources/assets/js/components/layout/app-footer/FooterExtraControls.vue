<template>
  <div class="extra-controls" data-testid="other-controls">
    <div class="wrapper">
      <a
        v-charon-tooltip.top
        class="visualizer-btn"
        data-testid="toggle-visualizer-btn"
        href="/#/visualizer"
        title="Show the visualizer"
      >
        <icon :icon="faBolt" />
      </a>

      <button
        v-if="useEqualizer"
        v-charon-tooltip.top
        :class="{ active: showEqualizer }"
        class="equalizer"
        title="Show equalizer"
        type="button"
        @click.prevent="showEqualizer"
      >
        <icon :icon="faSliders" />
      </button>

      <Volume />

      <button
        v-if="isFullscreenSupported()"
        v-charon-tooltip.top
        :title="fullscreenButtonTitle"
        @click.prevent="toggleFullscreen"
      >
        <icon :icon="isFullscreen ? faCompress : faExpand" />
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { faBolt, faCompress, faExpand, faSliders } from '@fortawesome/free-solid-svg-icons'
import { computed, onMounted, ref } from 'vue'
import { eventBus, isAudioContextSupported as useEqualizer, isFullscreenSupported } from '@/utils'

import Volume from '@/components/ui/Volume.vue'

const isFullscreen = ref(false)
const fullscreenButtonTitle = computed(() => (isFullscreen.value ? 'Exit fullscreen mode' : 'Enter fullscreen mode'))

const showEqualizer = () => eventBus.emit('MODAL_SHOW_EQUALIZER')
const toggleFullscreen = () => eventBus.emit('FULLSCREEN_TOGGLE')

onMounted(() => {
  document.addEventListener('fullscreenchange', () => {
    isFullscreen.value = Boolean(document.fullscreenElement)
  })
})
</script>

<style lang="scss" scoped>
.extra-controls {
  display: flex;
  justify-content: flex-end;
  position: relative;
  width: 320px;
  color: var(--color-text-secondary);
  padding: 0 2rem;

  :fullscreen & {
    padding-right: 0;
  }

  .wrapper {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 1.5rem;
  }

  button {
    color: currentColor;
    transition: color 0.2s ease-in-out;

    &:hover {
      color: var(--color-text-primary);
    }
  }

  @media only screen and (max-width: 768px) {
    width: auto;

    .visualizer-btn {
      display: none;
    }
  }

  :fullscreen & {
    .visualizer-btn {
      display: none;
    }
  }
}
</style>
