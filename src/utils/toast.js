import { useToast } from "vue-toastification";
import MyToast from "@/components/ToastMessage/mytoast.vue";

const toast = useToast();

export const showSuccessToast = (title, message, duration = 4000) => {
    toast.success({
        component: MyToast,
        props: {
            title: title,
            message: message,
            type: 'success',
            duration: duration
        }
    }, {
        icon: false,
        closeButton: false,
        timeout: duration
    });
};

export const showErrorToast = (title, message, duration = 4000) => {
    toast.error({
        component: MyToast,
        props: {
            title: title,
            message: message,
            type: 'error',
            duration: duration
        }
    }, {
        icon: false,
        closeButton: false,
        timeout: duration
    });
};

export const showInfoToast = (title, message, duration = 4000) => {
    toast.info({
        component: MyToast,
        props: {
            title: title,
            message: message,
            type: 'info',
            duration: duration
        }
    }, {
        icon: false,
        closeButton: false,
        timeout: duration
    });
};
