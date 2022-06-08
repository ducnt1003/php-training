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
        required: 'This field is required',
        success: 'Success',
        invalidemail: 'Invalid Email',
        textdelete: 'Are you sure to delete user {name} ?',
        textdeleteall: 'Are you sure to delete all selected user ?',
        error: 'Error',
        cancel: 'Cancel',
        ok: 'Ok',
        searchname: 'Search By Name',
        search: 'Search',
        all: 'All',
        createfail: 'Create Fail',
        createsuccess: 'Create Success',
        errorselect: 'Please select at least 1 user'

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
        required: 'Trường này không được bỏ trống',
        success: 'Thành công',
        invalidemail: 'Email sai định dạng',
        textdelete: 'Bạn có chắc muốn xóa người dùng {name} chứ ?',
        error: 'Lỗi',
        textdeleteall: 'Bạn có chắc muốn xóa tất cả người dùng đã chọn chứ ?',
        cancel: 'Hủy',
        ok: 'Đồng ý',
        searchname: 'Tìm theo tên',
        search: 'Tìm',
        all: 'Tất cả',
        createfail: 'Không thể tạo mới',
        createsuccess: 'Tạo mới thành công',
        errorselect: 'Vui lòng chọn ít nhất 1 người dùng'
    }
};

const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
});

export default i18n;
