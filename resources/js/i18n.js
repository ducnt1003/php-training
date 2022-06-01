import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const messages = {
    'en': {
        home:  'Home',
        users: 'Users',
        create: 'Create',
        edit: 'Edit',
        delete: 'Delete',
        name: 'Name',
        role: 'Role',
        logout: 'Logout',
        notfound: 'Page Not Found',
        servererror: 'Internal Server Error!!!',
        accessdeny: 'Access Forbidden',

    },
    'vi': {
        home:  'Trang chủ',
        users: 'Người dùng',
        create: 'Tạo mới',
        edit: 'Sửa',
        delete: 'Xóa',
        name: 'Tên',
        role: 'Vai trò',
        logout: 'Đăng xuất',
        notfound: 'Không tìm thấy trang',
        servererror: 'Lỗi server !!!',
        accessdeny: 'Truy cập bị cấm',
    }
};

const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
});

export default i18n;
