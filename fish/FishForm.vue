<script setup lang="ts">
import { ErrorMessage, Field } from 'vee-validate'
import { CCol, CRow } from '@coreui/vue'
import { CIcon } from '@coreui/icons-vue'
import { cilCamera, cilXCircle } from '@coreui/icons'
import { CFormInput, CFormTextarea } from '@coreui/vue/dist/esm/components/form'
import { inject, defineProps } from 'vue'
import type {
  Fish,
  FishFormData,
  FishMedia,
  FishMediaContent
} from '@/types/fish'
import { getError } from '@/helpers/errors'
import InputError from '@/components/InputError.vue'

/****************** Define Props ******************/
defineProps({
  type: String,
  fish: Object as () => Fish
})

const fishForm = inject<FishFormData>('fishForm')

if (!fishForm) {
  throw new Error('fishForm is not provided')
}
// Handle file selection
const mediaChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  const files = Array.from(target.files || [])
  handleFiles(files)
}

// Add selected files
const handleFiles = (files: File[]) => {
  files.forEach(file => {
    fishForm.fish_media.push({
      upload_file: file,
      url: URL.createObjectURL(file),
      status: 'create'
    })
  })
}
// Remove selected file or media from DB
const removeMedia = (media: FishMedia | FishMediaContent) => {
  if (!media.id) {
    const index = fishForm.fish_media.indexOf(media)
    fishForm.fish_media.splice(index, 1)
  } else {
    media.status = 'delete'
  }
}
</script>

<template>
  <div v-if="fishForm !== undefined">
    <CRow>
      <CCol md="12" class="mb-2">
        <label class="form-label" for="name">魚類名</label>
        <!-- Name -->
        <Field
          v-model="fishForm.name"
          :as="CFormInput"
          placeholder="魚類名を入力してください"
          name="name"
        />
        <ErrorMessage class="text-danger" name="name" />
        <InputError
          v-if="getError('name')"
          :error="getError('name')?.toString()"
        />
      </CCol>

      <CCol md="12" class="mb-2">
        <label class="form-label" for="description">概要</label>
        <!-- Description -->
        <Field
          v-model="fishForm.description"
          :as="CFormTextarea"
          rows="5"
          placeholder="概要を入力してください"
          name="description"
        />
        <ErrorMessage class="text-danger" name="description" />
      </CCol>

      <!-- Fish Medias Form -->
      <CCol md="12" class="mb-2">
        <label class="form-label" for="image">画像</label>
        <input
          id="file"
          name="media"
          type="file"
          accept="image/*"
          hidden
          @change="mediaChange($event)"
        />
        <label
          for="file"
          class="border rounded d-flex align-items-center justify-content-center p-2 cursor-pointer"
        >
          <CIcon :icon="cilCamera" size="lg" />
          <span class="px-2">画像を登録</span>
        </label>
        <InputError
          v-if="getError('fish_media')"
          :error="getError('fish_media')?.toString()"
        />
        <!-- Preview section for images (from DB and newly added) -->
        <template v-if="fishForm.fish_media && fishForm.fish_media.length > 0">
          <div
            class="d-flex flex-wrap justify-content-center lg:justify-content-start mt-2"
          >
            <template
              v-for="(media, index) in fishForm.fish_media"
              :key="index"
            >
              <div
                v-if="media.status !== 'delete'"
                class="position-relative overflow-hidden me-2"
              >
                <div
                  class="d-flex align-items-center justify-content-center position-absolute cursor-pointer bg-danger rounded-circle m-1"
                  @click="removeMedia(media)"
                >
                  <CIcon :icon="cilXCircle" class="text-white" size="lg" />
                </div>
                <div class="w-full h-full">
                  <img
                    v-if="!media.id"
                    :src="media.url"
                    width="100"
                    height="100"
                    class="rounded"
                  />
                  <img
                    v-else
                    :src="(media as FishMedia).file.url"
                    width="100"
                    height="100"
                    class="rounded"
                  />
                </div>
              </div>
            </template>
          </div>
        </template>
      </CCol>
    </CRow>
  </div>
</template>

<style scoped lang="scss">
img {
  object-fit: cover !important;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
