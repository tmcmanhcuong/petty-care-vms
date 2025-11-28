<template>
  <!-- Modal 1: Error - Cannot remove staff (has pending appointments) -->
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
          <p class="title-text error-title">⛔ Không thể gỡ nhân sự này</p>
        </div>
      </div>

      <!-- Staff info and warning message -->
      <div class="modal-body">
        <!-- Staff card -->
        <div class="staff-card">
          <img
            :src="staff.avatar"
            alt=""
            class="staff-avatar"
          />
          <div class="staff-info">
            <p class="staff-name">{{ staff.name }}</p>
            <p class="staff-position">{{ staff.position }}</p>
          </div>
        </div>

        <!-- Warning message -->
        <div class="warning-box">
          <div class="warning-content">
            <div class="warning-text-row">
              <span class="warning-bold">{{ staff.name }}</span>
              <span class="warning-normal">đang có</span>
              <span class="warning-bold">{{ appointmentCount }} lịch hẹn chưa hoàn thành</span>
            </div>
            <div class="warning-text-full">
              <p class="warning-normal">
                tại {{ departmentName }}. Vui lòng chuyển lịch hẹn cho bác sĩ khác hoặc hủy lịch trước khi gỡ nhân sự.
              </p>
            </div>
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

  <!-- Modal 2: Confirmation - Remove staff (no pending appointments) -->
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
          <p class="title-text confirm-title">Xác nhận gỡ nhân sự khỏi khoa?</p>
        </div>
      </div>

      <!-- Content -->
      <div class="modal-body">
        <!-- Confirmation message -->
        <div class="confirm-message">
          <p class="confirm-text">
            Bạn có chắc chắn muốn gỡ <span class="bold-text">{{ staff.name }}</span> ra khỏi biên chế <span class="bold-text">{{ departmentName }}</span> không?
          </p>
        </div>

        <!-- Staff card -->
        <div class="staff-card">
          <img
            :src="staff.avatar"
            alt=""
            class="staff-avatar"
          />
          <div class="staff-info">
            <p class="staff-name">{{ staff.name }}</p>
            <p class="staff-position">{{ staff.position }}</p>
          </div>
        </div>

        <!-- Info box -->
        <div class="info-box">
          <div class="info-content">
            <p class="info-text">
              📌 <span class="bold-text">Lưu ý:</span> Tài khoản của nhân viên này vẫn được giữ lại trên hệ thống nhưng sẽ chuyển về trạng thái <span class="bold-text">Chưa phân công</span>. Họ sẽ không còn quyền truy cập vào dữ liệu của khoa này nữa.
            </p>
          </div>
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
          class="btn-confirm-remove"
          @click="$emit('confirm')"
        >
          Xác nhận gỡ
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  modalType: {
    type: String,
    required: true,
    validator: (value) => ['error', 'confirm'].includes(value)
    // 'error' - Cannot remove (has pending appointments)
    // 'confirm' - Confirmation to remove (no pending appointments)
  },
  staff: {
    type: Object,
    required: true,
    // Expected: { name, position, avatar }
  },
  appointmentCount: {
    type: Number,
    default: 0
    // Required only for 'error' modalType
  },
  departmentName: {
    type: String,
    required: true
  }
})

defineEmits(['close', 'confirm'])

// Icon URLs from Figma (expire in 7 days)
const iconAlert = "https://www.figma.com/api/mcp/asset/01fca04d-2ca4-488c-92b8-10f337c1cc16"
const iconWarning = "https://www.figma.com/api/mcp/asset/aebf14b9-f7b9-420c-9846-80a5e26e0144"
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
  white-space: pre-wrap;
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
  white-space: pre-wrap;
}

.bold-text {
  font-weight: 700;
}

/* Staff card */
.staff-card {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  height: 74px;
  background: #f3f4f6;
  border: 1px solid #f3f4f6;
  border-radius: 10px;
  padding: 1px 13px;
}

.staff-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
}

.staff-info {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-width: 0;
}

.staff-name {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #111827;
  margin: 0;
}

.staff-position {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #6b7280;
  margin: 0;
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
  display: flex;
  flex-wrap: wrap;
  gap: 0;
  width: 100%;
}

.warning-text-row {
  display: flex;
  flex-wrap: wrap;
  align-items: start;
  gap: 4px;
  width: 100%;
  height: 24px;
}

.warning-text-full {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  margin-top: 0;
}

.warning-bold {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 700;
  font-size: 14px;
  line-height: 28px;
  color: #991b1b;
  flex-shrink: 0;
}

.warning-normal {
  font-family: 'Nunito Sans', sans-serif;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  color: #991b1b;
  flex-shrink: 0;
}

.warning-text-full .warning-normal {
  white-space: pre-wrap;
  flex: 1;
  min-width: 0;
}

/* Info box (blue) */
.info-box {
  background: #eff6ff;
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
  color: #1e40af;
  margin: 0;
  white-space: pre-wrap;
}

.info-text .bold-text {
  font-weight: 700;
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

.btn-confirm-remove {
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
  transition: background-color 0.2s;
}

.btn-confirm-remove:hover {
  background: #b91c1c;
}

.btn-confirm-remove:active {
  background: #991b1b;
}
</style>
