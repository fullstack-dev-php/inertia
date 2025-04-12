  <script setup lang="ts">
  import { Field, ErrorMessage, Form } from 'vee-validate';
  import { z } from 'zod';
  import { toTypedSchema } from '@vee-validate/zod';
  import { ref } from 'vue';
  const schema = z.object({
    image: z
     .union([z.instanceof(File), z.null()])
      .optional()
      .refine((file) => !file || file.size <= 2 * 1024 * 1024, {
        message: 'Kích thước ảnh phải nhỏ hơn 2MB.',
      }),
  });
  const values = {
    image: null
  }
  
  // Ref để reset UI của input file
  const inputKey = ref(Date.now());
  
  
  // Schema validation với zod
  
  // Submit handler
  const onSubmit = (values) => {
    console.log('🎉 File hợp lệ:', values);
  };
  
  function handleFileChange (value, handleChange, event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files ? target.files[0] : null;
    if (!file) {
        return;
    }
    value = file;
    handleChange(value)
}
  // Remove file handler
  const remove = (value, handleChange,) => {
    value = null;
    handleChange(value)
    inputKey.value = Date.now();
  };
  </script>
  <template>
    <Form @submit="onSubmit" :validation-schema="toTypedSchema(schema)" :initial-values="values">
      <Field name="image" v-slot="{value,handleChange}">
      <div class="mb-4">
          <input name="image" @change="handleFileChange(value,handleChange,$event)" type="file" accept="image/*" :key="inputKey" />
          <ErrorMessage name="image" class="text-red-500 text-sm mt-1" />
        </div>
        <p @click="remove(value,handleChange)" class="text-blue-600 cursor-pointer hover:underline mb-4">
          Remove
        </p>
      </Field>
      <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
        Gửi
      </button>
    </Form>
  </template>
  
  