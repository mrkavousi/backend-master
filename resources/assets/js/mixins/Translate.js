import Vue from 'vue'
import { mapState } from 'vuex'

Vue.mixin({
    data: () => ({
        translations: {
            en: {
                'pansea': 'PANSEA',
                'dashboard': 'Dashboard',
                'try.again.later': 'Something went wrong, please try again later.',
                'a.moment': 'A moment...',
                'are.you.sure': 'Are you sure?',
                'no.undo.action': 'By removing this item you can not restore it, are you sure?',
                'no.cancel': 'No, cancel',
                'yes.delete': 'Yes, delete it',
                'quantity': 'Quantity',
                'money.unit': 'Tomans',
                'million': 'Million',
                'deleted': 'Deleted!',
                'ok': 'OK',
                'logout': 'Logout',

                'add': 'Add',
                'list': 'List',
                'beta': 'Beta',
                'projects': 'Projects',
                'orders': 'Orders',
                'merchandises': 'Merchandises',
                'locations': 'Locations',
                'cities': 'Cities',
                'countries': 'Countries',
                'vehicles': 'Vehicles',
                'packages': 'Packages',
                'sizes': 'Sizes',
                'weights': 'Weights',
                'grades': 'Grades',
                'aquatics': 'Aquatics',
                'users': 'Users',
                'latest.active.projects': 'Latest active projects',
                'processing': 'Processing',
                'done': 'Done',
                'add.process': 'Add Process',
                'manage.all': 'Manage All',
                'latest.active.orders': 'Latest active orders',
                'shipping': 'Shipping',
                'add.shipment': 'Add Shipment',
                'latest.active.merchandises': 'Latest active merchandises',
                'login': 'Login',
                'login.pansea.cloud': 'Login to Pansea Cloud',
                'mobile.email': 'Mobile or Email',
                'password': 'Password',

                'add.aquatic': 'Add Aquatic',
                'aquatic.added.successfully': 'Aquatic added successfully',
                'name': 'Name',
                'description': 'Description',
                'optional': 'Optional',
                'save.publish': 'Save and Publish',
                'save': 'Save',
                'edit.aquatic': 'Edit Aquatic: :name',
                'aquatic.updated.successfully': 'Aquatic updated successfully',
                'all.aquatics': 'All Aquatics',
                'search': 'Search',
                'add.new.aquatic': 'Add New Aquatic',
                'id': 'ID',
                'created.at': 'Created At',
                'updated.at': 'Updated At',
                'add.new.project': 'Add New Project',
                'add.project': 'Add Project',
                'aquatic': 'Aquatic',
                'total.cost': 'Total Cost',
                'kg': 'Kg',
                'total.weight': 'Total Weight',
                'expected.packages': 'Expected Packages',
                'package': 'Package',
                'add.new': 'Add New',
                'add.another.package': 'Add another package',
                'overview': 'Overview',
                'packages.summary': 'Packages Summary',
                'total': 'Total',
                'all.processes': 'All Processes',
                'there.is.no.process.add': 'There is no process here, add first one.',
                'download': 'Download',
                'temperaturing.report': 'Temperaturing Report',
                'quality.controlling.report': 'Quality Controlling Report',
                'process.type': 'Process Type',
                'all.types': 'All Types',

                'sending': 'Sending',
                'delivering': 'Delivering',
                'unloading': 'Unloading',
                'weighting': 'Weighting',
                'sorting': 'Sorting',
                'defrosting': 'Defrosting',
                'entering': 'Entering',
                'exiting': 'Exiting',
                'staff-censusing': 'Staff Censusing',
                'temperaturing': 'Temperaturing',
                'quality-controlling': 'Quality Controlling',
                'note': 'Note',
                'frosting': 'Frosting',
                'packaging-before-frosting': 'Packaging Before Frosting',
                'packaging-after-frosting': 'Packaging After Frosting',

                'edit.project': 'Edit Project: :name',
                'results': 'Results',
                'from': 'From',
                'to': 'To',
                'current.location': 'Current Location',
                'tunnel': 'Tunnel',
                'vehicle': 'Vehicle',
                'driver': 'Driver',
                'trolley': 'Trolley',
                'you.adding.process.project': 'You are adding process to the project',
                'edit.project.2': 'Edit Project',
                'pallet': 'Pallet',
                'trolley.quantity': 'Trolley Quantity',
                'pallet.quantity': 'Pallet Quantity',
                'duration': 'Duration',
                'size': 'Size',
                'grade': 'Grade',
                'floor': 'Floor',
                'storage': 'Storage',
                'unload': 'Unload',
                'upcoming': 'Upcoming',
                'doing': 'Doing',
                'project': 'Project',
                'assign.sending.process': 'Assign a Sending Process',
                'assign.delivering.process': 'Assign a Delivering Process',
                'assign.unloading.process': 'Assign a Unloading Process',
                'assign.frosting.process': 'Assign a Frosting Process',
                'basket.quantity': 'Basket Quantity',
                'unilit.quantity': 'Unilit Quantity',
                'color': 'Color',
                'started.at': 'Started at',
                'ended.at': 'Ended at',
                'in.minutes': 'In Minutes',
                'done.at': 'Done at',
                'temprature': 'Temprature',
                'all.cities': 'All Cities',
                'add.new.city': 'Add new city',
                'country': 'Country',
                'tunnel': 'Tunnel',
                'process.status': 'Process Status',
                'final.packages': 'Final Packages',
                'add.output.packages.storage.specify.unload': 'Add output packages to storage and specify which unload blongs to.',
                'all.orders': 'All Orders',
                'add.new.order': 'Add New Order',
                'add.order': 'Add Order',
                'add.user': 'Add User',
                'email': 'Email',
                'mobile': 'Mobile',
                'role': 'Role',
                'locale': 'Locale',
                'user.added.successfully': 'User added successfully',
                'edit.user': 'Edit User: :name',
                'user.updated.successfully': 'User updated successfully',
                'edit': 'Edit',
                'add.process': 'Edit Process',
                'phone': 'Phone',
                'address': 'Address',
                'title': 'Title',
                'order.status': 'Order Status',
                'customer': 'Customer',
                'order': 'Order',
                'edit.order': 'Edit Order',
                'all.shipments': 'All Shipments',
                'notes': 'Notes',
                'new.note': 'New Note',
                'cancel': 'Cancel',
                'write.here': 'Write here...',
                'aquatic.type': 'Aquatic Type',
                'deadline': 'Deadline',
                'you.adding.shipment.order': 'You are adding shipment to the order',
                'inventory': 'Inventory',
                'no.inventory': 'No inventory',
                'code': 'Code',
                'selected.packages': 'Selected Packages',
                'storaged.in': 'Storaged in',
                'shipment.status': 'Shipment status',
                'edit.shipment': 'Edit shipment',
                'eta': 'Estimated time of arrival',
                'etd': 'Estimated time of departure',
                'total.selected.packages.quantity': 'Total Selected Packages Quantity',
                'total.selected.packages.weight': 'Total Selected Packages Weight',
                'status': 'Status',
                'edit.location': 'Edit Location',
                'city': 'City',
                'parent.location': 'Parent Location',
                'location.type': 'Location Type',
                'coordinate': 'Coordinate',
                'coordinate.example': 'Example: 35.7211182,51.3907133',
                'capacity': 'Capacity',
                'add.location': 'Add Location',
            },



            fa: {
                'pansea': 'PANSEA',
                'dashboard': 'داشبورد',
                'try.again.later': 'یک مشکلی وجود دارد. لطفا چند دقیقه دیگر دوباره تلاش کنید.',
                'a.moment': 'یک لحظه...',
                'are.you.sure': 'مطمئنید؟',
                'no.undo.action': 'حذف این آیتم غیرقابل بازگشت است، از این کار اطمینان کامل دارید؟',
                'no.cancel': 'نه، بیخیال',
                'yes.delete': 'بله، حذف کن',
                'quantity': 'تعداد',
                'money.unit': 'تومان',
                'deleted': 'حذف شد!',
                'ok': 'خب',
                'logout': 'خروج',

                'add': 'افزودن',
                'list': 'لیست',
                'beta': 'آزمایشی',
                'projects': 'پروژه‌ها',
                'orders': 'سفارشات',
                'merchandises': 'کالاها و اقلام',
                'locations': 'اماکن',
                'cities': 'شهرها',
                'countries': 'کشورها',
                'vehicles': 'وسایل نقلیه',
                'packages': 'بسته‌بندی‌ها',
                'sizes': 'سایزها',
                'weights': 'وزن‌ها',
                'grades': 'رده‌بندی‌ها',
                'aquatics': 'آبزیان',
                'users': 'کاربران',
                'latest.active.projects': 'آخرین پروژه‌های فعال',
                'processing': 'درحال پردازش',
                'done': 'انجام‌شده',
                'add.process': 'افزودن فرآیند',
                'manage.all': 'مدیریت همه',
                'latest.active.orders': 'آخرین سفارش‌های فعال',
                'shipping': 'درحال حمل‌ونقل',
                'add.shipment': 'افزودن حمل‌ونقل',
                'latest.active.merchandises': 'آخرین اقلام فعال',
                'login': 'ورود',
                'login.pansea.cloud': 'ورود به پنسی کلاد',
                'mobile.email': 'موبایل یا ایمیل',
                'password': 'رمز عبور',

                'add.aquatic': 'افزودن آبزی',
                'aquatic.added.successfully': 'آبزی با موفقیت افزوده شد',
                'name': 'نام',
                'description': 'توضیحات',
                'optional': 'اختیاری',
                'save.publish': 'ذخیره و انتشار',
                'save': 'ذخیره',
                'edit.aquatic': 'ویرایش آبزی: :name',
                'aquatic.updated.successfully': 'آبزی با موفقیت به‌روز شد',
                'all.aquatics': 'همه آبزیان',
                'search': 'جستجو',
                'add.new.aquatic': 'افزودن آبزی جدید',
                'id': 'کد',
                'created.at': 'ثبت',
                'updated.at': 'به‌روزرسانی',
                'add.new.project': 'افزودن پروژه جدید',
                'add.project': 'افزودن پروژه',
                'aquatic': 'آبزی',
                'total.cost': 'کل هزینه',
                'kg': 'Kg',
                'total.weight': 'وزن کل',
                'expected.packages': 'بسته‌بندی‌های مورد انتظار',
                'package': 'بسته‌بندی',
                'add.new': 'افزودن',
                'add.another.package': 'یکی دیگه',
                'overview': 'بررسی کلی',
                'packages.summary': 'بسته‌بندی‌ها در یک نگاه',
                'total': 'کل',
                'all.processes': 'همه فرآیندها',
                'there.is.no.process.add': 'هیچ فرآیندی وجود ندارد، اولی را ثبت کنید.',
                'download': 'دریافت',
                'temperaturing.report': 'گزارش دماسنجی',
                'quality.controlling.report': 'گزارش کنترل کیفی',
                'process.type': 'نوع فرآیند',
                'all.types': 'همه',

                'sending': 'ارسال',
                'delivering': 'تحویل',
                'unloading': 'تخلیه',
                'weighting': 'وزن‌گیری',
                'sorting': 'مرتب‌سازی',
                'defrosting': 'یخ‌زدایی',
                'entering': 'ورود',
                'exiting': 'خروج',
                'staff-censusing': 'شمارش کارکنان',
                'temperaturing': 'دماسنجی',
                'quality-controlling': 'کنترل کیفی',
                'note': 'یادداشت',
                'frosting': 'انجماد',
                'packaging-before-frosting': 'بسته‌بندی قبل از انجماد',
                'packaging-after-frosting': 'بسته‌بندی پس از انجماد',

                'edit.project': 'ویرایش پروژه: :name',
                'results': 'نتیجه',
                'from': 'از',
                'to': 'به',
                'current.location': 'مکان فعلی',
                'tunnel': 'تونل',
                'vehicle': 'وسیله نقلیه',
                'driver': 'راننده',
                'trolley': 'چرخ‌دستی',
                'you.adding.process.project': 'شما در حال افزودن فرآیند به پروژه هستید',
                'edit.project.2': 'ویرایش پروژه',
                'pallet': 'پالت',
                'trolley.quantity': 'تعداد چرخ‌دستی',
                'pallet.quantity': 'تعداد پالت',
                'duration': 'مدت زمان',
                'size': 'اندازه',
                'grade': 'رده',
                'floor': 'طبقه',
                'storage': 'انبار',
                'unload': 'تخلیه',
                'upcoming': 'به زودی',
                'doing': 'درحال انجام',
                'project': 'پروژه',
                'assign.sending.process': 'فرآیند ارسال را مشخص کنید',
                'assign.delivering.process': 'فرآیند تحویل را مشخص کنید',
                'assign.unloading.process': 'فرآیند تخلیه را مشخص کنید',
                'assign.frosting.process': 'فرآیند انجماد را مشخص کنید',
                'basket.quantity': 'تعداد سبد',
                'unilit.quantity': 'تعداد یونیلیت',
                'color': 'رنگ',
                'started.at': 'زمان شروع',
                'ended.at': 'زمان پایان',
                'in.minutes': 'دقیقه',
                'done.at': 'انجام‌شده در',
                'temprature': 'درجه حرارت',
                'all.cities': 'همه شهرها',
                'add.new.city': 'افزودن شهر جدید',
                'country': 'کشور',
                'tunnel': 'تونل',
                'process.status': 'وضعیت فرآیند',
                'final.packages': 'بسته‌بندی‌های نهایی',
                'add.output.packages.storage.specify.unload': 'بسته‌بندی‌های خروجی را برای ذخیره شدن در انبار ثبت کنید و مشخص کنید به کدام فرآیند تخلیه مربوط است.',
                'all.orders': 'همه سفارشات',
                'add.new.order': 'افزودن سفارش جدید',
                'add.order': 'افزودن سفارش',
                'add.user': 'افزودن کاربر',
                'email': 'ایمیل',
                'mobile': 'موبایل',
                'role': 'نقش',
                'locale': 'زبان',
                'user.added.successfully': 'کاربر با موفقیت افزوده شد',
                'edit.user': 'ویرایش کاربر: :name',
                'user.updated.successfully': 'کاربر با موفقیت به‌روز شد',
                'edit': 'ویرایش',
                'edit.process': 'ویرایش فرآیند',
                'phone': 'تلفن',
                'address': 'آدرس',
                'title': 'عنوان',
                'order.status': 'وضعیت سفارش',
                'customer': 'مشتری',
                'order': 'سفارش',
                'edit.order': 'ویرایش سفارش',
                'all.shipments': 'همه حمل‌ونقل‌ها',
                'notes': 'نوت‌ها',
                'new.note': 'نوت جدید',
                'cancel': 'انصراف',
                'write.here': 'همینجا بنویسید...',
                'aquatic.type': 'نوع آبزی',
                'deadline': 'تاریخ مهلت',
                'you.adding.shipment.order': 'شما در حال افزودن حمل‌ونقل به سفارش هستید',
                'inventory': 'موجودی',
                'no.inventory': 'هیچ موجودی‌ای ندارد',
                'code': 'کد',
                'selected.packages': 'بسته‌های انتخابی',
                'storaged.in': 'ذخیره‌شده در',
                'shipment.status': 'وضعیت حمل‌ونقل',
                'edit.shipment': 'ویرایش حمل‌ونقل',
                'eta': 'زمان تقریبی رسیدن',
                'etd': 'زمان تقریبی حرکت',
                'total.selected.packages.quantity': 'تعداد کل بسته‌بندی‌های انتخابی',
                'total.selected.packages.weight': 'وزن کل بسته‌بندی‌های انتخابی',
                'status': 'وضعیت',
                'edit.location': 'ویرایش مکان',
                'city': 'شهر',
                'parent.location': 'مکان والد',
                'location.type': 'نوع مکان',
                'coordinate': 'نقطه مکانی',
                'coordinate.example': 'مثال: 35.7211182,51.3907133',
                'capacity': 'ظرفیت',
                'add.location': 'افزودن مکان',
            },
        }
    }),

    computed: mapState({
        locale: state => state.locale
    }),

    methods: {
        Translate: function (translateKey, params) {
            var string = this.translations[this.locale][translateKey]
    
            if (params)
                for (const key in params) {
                    let value = params[key]
                    
                    if (params.hasOwnProperty(key))
                        string = string.replace(':' + key, value)
                }

            return string
        }
    }
})
