<script setup lang="ts">
import { defineProps, ref, inject } from 'vue';
import type { ImageInterface } from '@/types/image';

// Định nghĩa props để nhận avatar từ database (nếu có)

const userForm = <ImageInterface>inject('userForm');
const avatarFromDb = inject<string | null>('avatarFromDb');
// Hàm để lấy đường dẫn ảnh từ database
const getImage = (img: string) => {
    return `http://localhost/innertia/storage/app/public/` + img;
};

// Khởi tạo imgPreview với avatar mặc định hoặc avatar từ database
const imgPreview = ref<string>(
    avatarFromDb ? getImage(avatarFromDb) :
        "https://t4.ftcdn.net/jpg/05/49/98/39/360_F_549983970_bRCkYfk0P6PP5fKbMhZMIb07mCJ6esXL.jpg"
);

interface InputFileEvent extends Event {
    target: HTMLInputElement & EventTarget;
}

// Thay đổi ảnh preview khi chọn ảnh mới
const onchangeImage = (e: InputFileEvent | null) => {
    if (!e || !e.target?.files) return;
    //get files from Event
    const files: FileList | null = (e.target as HTMLInputElement).files;
    if (!files || files.length === 0) {
        return;
    }

    userForm.avatar = files[0];

    imgPreview.value = URL.createObjectURL(files[0]);
};
</script>

<template>
    <div>
        <img v-if="imgPreview" :src="imgPreview" class="rounded-circle mt-5" width="350px" />
        <label for="upload" class="btn btn-success my-4">Upload</label>
        <input type="file" @change="onchangeImage($event as InputFileEvent)" id="upload" accept="image/*" />
    </div>
</template>
