<template>
  <!-- Modal 1: Error - Cannot delete room (room is in use) -->
  <div
    v-if="modalType === 'error'"
    class="modal-overlay"
    @click.self="$emit('close')"
  >
    <div class="modal-container">
      <!-- Header with error icon and title -->
      <div class="modal-header">
        <div class="error-icon-container">
          <div class="error-icon-wrapper">
            <img
              :src="iconAlert"
              alt=""
              class="error-icon"
            />
          </div>
        </div>
        <div class="modal-title">
          <p class="title-text error-title">⛔ Không thể xoá phòng này</p>
        </div>
      </div>

      <!-- Content -->
      <div class="modal-body">
        <!-- Room card -->
        <div class="room-card">
          <div class="room-info">
            <p class="room-name">{{ room.name }}</p>
            <div class="room-meta">
              <p class="room-type">{{ room.type }} •</p>
              <div class="badge badge-in-use">
                <span class="badge-text">Đang sử dụng</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Warning message -->
        <div class="warning-box">
          <div class="warning-content">
            <p class="warning-text">
              <span class="warning-bold">{{ room.name }}</span> đang ở trạng thái <span class="warning-bold">Đang sử dụng</span>. Vui lòng kết thúc các ca khám/hoạt động hiện tại trước khi xóa.
            </p>
          </div>
        </div>
      </div>

      <!-- Action button -->
      <button
        type="button"
        class="btn-understood"
        @click="$emit('close')"
      >
        Đã hiểu
      </button>
    </div>
  </div>

  <!-- Modal 2: Confirmation - Delete room (room is empty) -->
  <div
    v-else-if="modalType === 'confirm'"
    class="modal-overlay"
    @click.self="$emit('close')"
  >
    <div class="modal-container">
      <!-- Header with warning icon and title -->
      <div class="modal-header">
        <div class="warning-icon-container">
          <div class="warning-icon-wrapper">
            <img
              :src="iconWarning"
              alt=""
              class="warning-icon"
            />
          </div>
        </div>
        <div class="modal-title">
          <p class="title-text confirm-title">Xác nhận Phòng?</p>
        </div>
      </div>

      <!-- Content -->
      <div class="modal-body">
        <!-- Confirmation message -->
        <div class="confirm-message">
          <p class="confirm-text">
            Bạn có chắc chắn muốn xóa vĩnh viễn <span class="bold-text">{{ room.name }}</span> không?
          </p>
        </div>

        <!-- Room card -->
        <div class="room-card">
          <div class="room-info">
            <p class="room-name">{{ room.name }}</p>
            <div class="room-meta">
              <p class="room-type">{{ room.type }} •</p>
              <div class="badge badge-empty">
                <span class="badge-text">Trống</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Info box -->
        <div class="info-box">
          <div class="info-content">
            <p class="info-text">
              ⚠️ <span class="bold-text">Lưu ý:</span> Các lịch hẹn trong quá khứ tại phòng này vẫn được lưu trữ, nhưng bạn sẽ không thể xếp lịch mới vào phòng này nữa.
            </p>
          </div>
        </div>

        <!-- DELETE confirmation input -->
        <div class="confirmation-input-container">
          <div class="confirmation-label">
            <span class="label-text">Gõ chữ</span>
            <span class="delete-text">DELETE</span>
            <span class="label-text">để xác nhận:</span>
          </div>
          <input
            v-model="deleteConfirmation"
            type="text"
            class="confirmation-input"
            placeholder="DELETE"
            @input="validateInput"
          />
        </div>
      </div>

      <!-- Action buttons -->
      <div class="modal-footer">
        <button
          type="button"
          class="btn-cancel"
          @click="$emit('close')"
        >
          Hủy bỏ
        </button>
        <button
          type="button"
          class="btn-confirm-delete"
          :disabled="!isDeleteConfirmed"
          @click="handleConfirm"
        >
          Xác nhận gỡ
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue'

const props = defineProps({
  modalType: {
    type: String,
    required: true,
    validator: (value) => ['error', 'confirm'].includes(value)
    // 'error' - Cannot delete (room is in use)
    // 'confirm' - Confirmation to delete (room is empty)
  },
  room: {
    type: Object,
    required: true,
    // Expected: { name, type }
  }
})

const emit = defineEmits(['close', 'confirm'])

// DELETE confirmation input
const deleteConfirmation = ref('')

// Validate if user typed "DELETE" correctly
const isDeleteConfirmed = computed(() => {
  return deleteConfirmation.value === 'DELETE'
})

const validateInput = () => {
  // You can add additional validation logic here if needed
}

const handleConfirm = () => {
  if (isDeleteConfirmed.value) {
    emit('confirm', { roomId: props.room.id, roomName: props.room.name })
  }
}

// Icon URLs from Figma (expire in 7 days)
const iconAlert = "https://www.figma.com/api/mcp/asset/39790cbc-4c0d-401e-a042-17ae5569c4f5"
const iconWarning = "https://www.figma.com/api/mcp/asset/d8c42ba4-82e6-4ea0-b855-fd826629b967"
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-container {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 10px;
  width: 512px;
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Header */
.modal-header {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  height: 48px;
}

/* Error icon (red) */
.error-icon-container {
  background: #fee2e2;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.error-icon-wrapper {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.error-icon {
  width: 24px;
  height: 24px;
  display: block;
}

/* Warning icon (amber/yellow) */
.warning-icon-container {
  background: #fef3c7;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.warning-icon-wrapper {
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.warning-icon {
  width: 24px;
  height: 24px;
  display: block;
}

.modal-title {
  flex: 1;
  min-width: 0;
}

.title-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 700;
  font-size: 18px;
  line-height: 28px;
  margin: 0;
}

.error-title {
  color: #dc2626;
}

.confirm-title {
  color: #111827;
}

/* Body */
.modal-body {
  display: flex;
  flex-direction: column;
  gap: 16px;
  width: 100%;
}

/* Confirmation message */
.confirm-message {
  width: 100%;
}

.confirm-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #374151;
  margin: 0;
}

.bold-text {
  font-weight: 700;
}

/* Room card */
.room-card {
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: 100%;
  background: #f3f4f6;
  border: 1px solid #f3f4f6;
  border-radius: 10px;
  padding: 12px;
}

.room-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: 100%;
}

.room-name {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 700;
  font-size: 14px;
  line-height: 28px;
  color: #111827;
  margin: 0;
}

.room-meta {
  display: flex;
  align-items: center;
  gap: 4px;
}

.room-type {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #6b7280;
  margin: 0;
}

/* Badges */
.badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 2px 8px;
  border-radius: 8px;
  border: 1px solid transparent;
}

.badge-in-use {
  background: #dbeafe;
}

.badge-in-use .badge-text {
  color: #2563eb;
}

.badge-empty {
  background: #e5e7eb;
}

.badge-empty .badge-text {
  color: #4b5563;
}

.badge-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
}

/* Warning box (red) */
.warning-box {
  background: #fef2f2;
  border: 1px solid #fca5a5;
  border-radius: 10px;
  padding: 16px;
  width: 100%;
}

.warning-content {
  width: 100%;
}

.warning-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #991b1b;
  margin: 0;
  white-space: pre-wrap;
}

.warning-bold {
  font-weight: 700;
}

/* Info box (amber/yellow) */
.info-box {
  background: #fffbeb;
  border: 1px solid #93c5fd;
  border-radius: 10px;
  padding: 16px;
  width: 100%;
}

.info-content {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.info-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #b45309;
  margin: 0;
  white-space: pre-wrap;
}

.info-text .bold-text {
  font-weight: 700;
}

/* Confirmation input */
.confirmation-input-container {
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: 100%;
}

.confirmation-label {
  display: flex;
  align-items: center;
  gap: 4px;
}

.label-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #000000;
}

.delete-text {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 700;
  font-size: 18px;
  line-height: 16px;
  color: #dc2626;
  padding: 2px 0;
}

.confirmation-input {
  background: #f3f4f6;
  border: 1px solid transparent;
  border-radius: 8px;
  height: 36px;
  padding: 4px 12px;
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #111827;
  width: 100%;
  outline: none;
  transition: border-color 0.2s, background-color 0.2s;
}

.confirmation-input::placeholder {
  color: #6b7280;
}

.confirmation-input:focus {
  border-color: #5a9690;
  background: #ffffff;
}

/* Footer */
.modal-footer {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 8px;
  width: 100%;
}

/* Action buttons */
.btn-understood {
  background: #4b5563;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #ffffff;
  text-align: center;
  flex-shrink: 0;
  transition: background-color 0.2s;
  align-self: flex-end;
}

.btn-understood:hover {
  background: #374151;
}

.btn-understood:active {
  background: #1f2937;
}

.btn-cancel {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 8px;
  padding: 9px 17px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #000000;
  text-align: center;
  flex-shrink: 0;
  transition: background-color 0.2s;
}

.btn-cancel:hover {
  background: #f9fafb;
}

.btn-cancel:active {
  background: #f3f4f6;
}

.btn-confirm-delete {
  background: #dc2626;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 20px;
  color: #ffffff;
  text-align: center;
  flex-shrink: 0;
  transition: background-color 0.2s, opacity 0.2s;
}

.btn-confirm-delete:hover:not(:disabled) {
  background: #b91c1c;
}

.btn-confirm-delete:active:not(:disabled) {
  background: #991b1b;
}

.btn-confirm-delete:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
