<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-6">
    <div class="bg-white border border-black/10 rounded-[10px] w-full max-w-[495px] max-h-[90vh] overflow-y-auto">
      <div class="p-6 flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-col gap-2">
          <h2 class="font-nunito font-semibold text-2xl leading-8 text-neutral-950 tracking-[0.0703px]">
            Chi tiết hóa đơn - {{ invoice.code }}
          </h2>
          <p class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">
            Thông tin chi tiết và lịch sử thanh toán
          </p>
        </div>

        <!-- Invoice Info Card -->
        <div class="bg-gray-50 rounded-[10px] p-4 grid grid-cols-2 gap-4">
          <!-- Customer -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#4a5565] tracking-tight mb-2">
              Khách hàng
            </label>
            <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
              {{ invoice.customer }} ({{ invoice.phone }})
            </p>
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
              Pet: {{ invoice.petName }}
            </p>
          </div>

          <!-- Doctor -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#4a5565] tracking-tight mb-2">
              Bác sĩ chỉ định
            </label>
            <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
              {{ invoice.doctor }}
            </p>
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
              {{ invoice.department }}
            </p>
          </div>

          <!-- Create Date -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#4a5565] tracking-tight mb-2">
              Ngày tạo
            </label>
            <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
              {{ invoice.time }} - {{ invoice.date }}
            </p>
          </div>

          <!-- Collector -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#4a5565] tracking-tight mb-2">
              Người thu
            </label>
            <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
              {{ invoice.collector }}
            </p>
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
              {{ invoice.collectorDepartment }}
            </p>
          </div>
        </div>

        <!-- Services & Medicine List -->
        <div class="flex flex-col gap-3">
          <h3 class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
            Danh sách Dịch vụ & Thuốc
          </h3>
          <div class="border border-black/10 rounded-[10px] overflow-hidden">
            <table class="w-full">
              <thead>
                <tr class="border-b border-black/10">
                  <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                    Tên dịch vụ/Thuốc
                  </th>
                  <th class="text-center px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                    SL
                  </th>
                  <th class="text-right px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                    Đơn giá
                  </th>
                  <th class="text-right px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                    Thành tiền
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item, index) in invoice.items"
                  :key="index"
                  class="border-b border-black/10"
                >
                  <td class="px-2 py-[9px] font-nunito text-sm leading-5 text-neutral-950 tracking-tight">
                    {{ item.name }}
                  </td>
                  <td class="px-2 py-[9px] font-nunito text-sm leading-5 text-neutral-950 text-center tracking-tight">
                    {{ item.quantity }}
                  </td>
                  <td class="px-2 py-[9px] font-nunito text-sm leading-5 text-neutral-950 text-right tracking-tight">
                    {{ formatCurrency(item.price) }}
                  </td>
                  <td class="px-2 py-[9px] font-nunito text-sm leading-5 text-neutral-950 text-right tracking-tight">
                    {{ formatCurrency(item.total) }}
                  </td>
                </tr>
                <!-- Total Row -->
                <tr class="bg-gray-50">
                  <td colspan="3" class="px-2 py-[14px] font-nunito font-bold text-sm leading-5 text-neutral-950 text-right tracking-tight">
                    Tổng cộng:
                  </td>
                  <td class="px-2 py-[11.5px] font-nunito font-bold text-lg leading-7 text-neutral-950 text-right tracking-tight">
                    {{ formatCurrency(invoice.totalAmount) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Payment History -->
        <div class="flex flex-col gap-3">
          <h3 class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
            Lịch sử Giao dịch (Payment History)
          </h3>
          <div class="flex flex-col gap-3">
            <!-- Transaction Item -->
            <div
              v-for="(transaction, index) in invoice.transactions"
              :key="index"
              class="bg-white border border-black/10 rounded-[10px] p-[17px] flex items-start justify-between"
            >
              <div class="flex flex-col gap-2 flex-1">
                <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                  {{ transaction.time }} - {{ transaction.date }}
                </p>
                <div class="flex flex-col gap-2">
                  <p class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
                    {{ transaction.methodIcon }} {{ transaction.method }}
                  </p>
                  <div class="flex items-baseline gap-2">
                    <span class="font-nunito text-lg leading-7 text-[#101828] tracking-tight">
                      Số tiền:
                    </span>
                    <span class="font-nunito font-bold text-lg leading-7 text-[#009689] tracking-tight">
                      {{ formatCurrency(transaction.amount) }}
                    </span>
                  </div>
                  <p class="font-nunito italic text-sm leading-5 text-[#4a5565] tracking-tight">
                    Ghi chú: {{ transaction.note }}
                  </p>
                </div>
              </div>
              <span
                :class="[
                  'inline-flex items-center gap-1 px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4',
                  transaction.status === 'success' ? 'bg-green-100 text-[#008236]' : 'bg-red-100 text-[#c10007]'
                ]"
              >
                <img v-if="transaction.status === 'success'" :src="iconCheck" alt="Success" class="w-3 h-3" />
                {{ transaction.status === 'success' ? 'Thành công' : 'Thất bại' }}
              </span>
            </div>

            <!-- Final Status -->
            <div class="bg-teal-50 border border-[#96f7e4] rounded-[10px] p-[17px]">
              <div class="flex flex-col gap-1">
                <p class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
                  Trạng thái cuối:
                </p>
                <div class="flex items-center gap-3">
                  <span class="inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 bg-green-100 text-[#008236]">
                    ✅ Đã thanh toán
                  </span>
                  <div class="flex items-baseline gap-2">
                    <span class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
                      Đã thanh toán:
                    </span>
                    <span class="font-nunito font-bold text-sm leading-5 text-[#00a63e] tracking-tight">
                      {{ formatCurrency(invoice.paidAmount) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Promotion Code -->
        <div v-if="invoice.promotion" class="flex flex-col gap-3">
          <h3 class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
            🎟️ Mã khuyến mãi
          </h3>
          <div class="bg-teal-50 border-2 border-[#46ecd5] rounded-[10px] p-[18px]">
            <div class="flex items-start justify-between">
              <div class="flex flex-col gap-2 flex-1">
                <div class="flex items-center gap-3">
                  <span class="inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 bg-[#009689] text-white">
                    {{ invoice.promotion.code }}
                  </span>
                  <p class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
                    {{ invoice.promotion.description }}
                  </p>
                </div>
                <div class="flex items-center gap-4">
                  <div class="flex items-baseline gap-2">
                    <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                      Loại:
                    </span>
                    <span class="font-nunito font-bold text-sm leading-5 text-[#4a5565] tracking-tight">
                      {{ invoice.promotion.type }}
                    </span>
                  </div>
                  <div class="flex items-baseline gap-2">
                    <span class="font-nunito text-lg leading-7 text-[#00786f] tracking-tight">
                      Giảm giá:
                    </span>
                    <span class="font-nunito font-bold text-lg leading-7 text-[#009689] tracking-tight">
                      {{ formatCurrency(invoice.promotion.discount) }}
                    </span>
                  </div>
                </div>
              </div>
              <span class="inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 bg-green-100 text-[#008236]">
                Đã áp dụng
              </span>
            </div>
          </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex items-center justify-end gap-2">
          <button
            @click="$emit('close')"
            class="bg-white border border-black/10 rounded-lg h-9 px-[17px] py-[9px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight hover:bg-gray-50 transition-colors"
          >
            Đóng
          </button>
          <button
            @click="printInvoice"
            class="bg-white border border-black/10 rounded-lg h-9 px-[13px] flex items-center gap-2 font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight hover:bg-gray-50 transition-colors"
          >
            <img :src="iconPrint" alt="Print" class="w-4 h-4" />
            In hóa đơn
          </button>
          <button
            @click="refundInvoice"
            class="bg-[#d4183d] rounded-lg h-9 px-[12px] flex items-center gap-2 font-nunito font-medium text-sm leading-5 text-white tracking-tight hover:bg-[#b71535] transition-colors"
          >
            <img :src="iconRefund" alt="Refund" class="w-4 h-4" />
            Hoàn tiền
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Props
const props = defineProps({
  invoice: {
    type: Object,
    default: () => ({
      code: 'HD001234',
      customer: 'Nguyễn Văn A',
      phone: '0901234567',
      petName: 'Milo',
      doctor: 'BS. Nguyễn Văn B',
      department: 'Khoa Lâm Sàng',
      time: '10:30',
      date: '20/11/2025',
      collector: 'Thu ngân Mai',
      collectorDepartment: 'Khoa Vận hành',
      items: [
        {
          name: 'Khám tổng quát',
          quantity: 1,
          price: 150000,
          total: 150000
        },
        {
          name: 'Siêu âm ổ bụng',
          quantity: 1,
          price: 300000,
          total: 300000
        },
        {
          name: 'Thuốc A (Omeprazole)',
          quantity: 2,
          price: 50000,
          total: 100000
        },
        {
          name: 'Thuốc B (Metronidazole)',
          quantity: 1,
          price: 450000,
          total: 450000
        }
      ],
      totalAmount: 1000000,
      paidAmount: 1000000,
      transactions: [
        {
          time: '10:30',
          date: '20/11/2025',
          method: 'Tiền mặt',
          methodIcon: '💵',
          amount: 500000,
          note: 'Thanh toán tại quầy',
          status: 'success'
        }
      ],
      promotion: {
        code: 'NEWCUSTOMER2025',
        description: 'Khuyến mãi khách hàng mới',
        type: 'Giảm cố định',
        discount: -100000
      }
    })
  }
})

// Emits
const emit = defineEmits(['close', 'print', 'refund'])

// Icons (from Figma - expire in 7 days)
const iconCheck = "https://www.figma.com/api/mcp/asset/367b5d70-39bf-4317-815a-dfd1cb397d73"
const iconPrint = "https://www.figma.com/api/mcp/asset/951df8cf-41b3-429b-a733-64acd07f888d"
const iconRefund = "https://www.figma.com/api/mcp/asset/b06c2e12-bea4-406b-960f-580f9b22d480"

// Methods
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
    minimumFractionDigits: 0
  }).format(amount).replace('₫', 'đ')
}

const printInvoice = () => {
  emit('print', props.invoice)
}

const refundInvoice = () => {
  emit('refund', props.invoice)
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
