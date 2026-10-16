# KẾ HOẠCH PHÁT TRIỂN DỰ ÁN DT-16

## 1. Nguyên tắc

- Backend và Frontend nằm trong cùng repository GitHub.
- Thực hiện trên Windows và sử dụng PowerShell.
- Kiểm tra trạng thái trước khi thay đổi file hoặc cấu hình.
- Mỗi tính năng có tiêu chí hoàn thành và kiểm thử.
- Không đánh dấu hoàn thành nếu chưa có kết quả kiểm chứng.

## 2. Lộ trình 12 phần, 36 buổi

### Phần I - Khởi động và GitHub
- Buổi 1: Đặc tả yêu cầu, phạm vi và phân công.
- Buổi 2: Tạo repository, cấu trúc thư mục và quy tắc Git.

### Phần II - Thiết kế hệ thống
- Buổi 3: Thiết kế dữ liệu và quan hệ.
- Buổi 4: Thiết kế không gian 360°, điểm nhìn, Gateway, hotspot.
- Buổi 5: Thiết kế hợp đồng REST API.

### Phần III - Khởi tạo Backend
- Buổi 6: Khởi tạo Laravel và cấu hình API.
- Buổi 7: Migration, model, quan hệ và dữ liệu mẫu.
- Buổi 8: Chuẩn hóa Request, Service, Resource và test nền.

### Phần IV - Tài khoản và bảo mật
- Buổi 9: Đăng ký, đăng nhập, đăng xuất.
- Buổi 10: Phân quyền và hồ sơ cá nhân.
- Buổi 11: Kiểm thử bảo mật cơ bản.

### Phần V - Quản lý dữ liệu bảo tàng
- Buổi 12: API và giao diện quản lý hiện vật.
- Buổi 13: Không gian, điểm nhìn và Gateway.
- Buổi 14: Hotspot và tài nguyên đa phương tiện.

### Phần VI - Tour và nội dung đa ngữ
- Buổi 15: Tour chủ đề và thứ tự điểm dừng.
- Buổi 16: Audio tiếng Việt và tiếng Anh.
- Buổi 17: Bắt đầu tour và theo dõi tiến trình.

### Phần VII - Khởi tạo Frontend
- Buổi 18: Khởi tạo Vue 3 + Vite.
- Buổi 19: Layout, định tuyến và màn hình nền.
- Buổi 20: Kết nối API và xử lý trạng thái.

### Phần VIII - Trình xem 360°
- Buổi 21: Panorama 360°.
- Buổi 22: Gateway và MiniMap.
- Buổi 23: Hotspot và thông tin hiện vật.

### Phần IX - Trải nghiệm tham quan
- Buổi 24: Chế độ tự do.
- Buổi 25: Chế độ có hướng dẫn.
- Buổi 26: Bộ sưu tập cá nhân và sổ lưu bút.

### Phần X - Quản trị và phân tích
- Buổi 27: Trang quản trị.
- Buổi 28: Thu thập sự kiện và thống kê.
- Buổi 29: Tích hợp mô-đun Python.

### Phần XI - Kiểm thử và tối ưu
- Buổi 30: Tối ưu tải panorama và media.
- Buổi 31: Kiểm thử chức năng đầu cuối.
- Buổi 32: Bảo mật và tương thích.
- Buổi 33: Hiệu năng và nghiệm thu nội bộ.

### Phần XII - Triển khai và bàn giao
- Buổi 34: Kiểm tra điều kiện Hostinger.
- Buổi 35: Triển khai website trực tuyến.
- Buổi 36: Nghiệm thu, báo cáo và phát hành.

## 3. Các mốc kiểm soát

- M0: Môi trường phát triển đã được kiểm tra.
- M1: Repository và đặc tả đã sẵn sàng.
- M2: Backend và database nền hoạt động.
- M3: API nghiệp vụ chính hoạt động.
- M4: Luồng tham quan 360° hoạt động.
- M5: Quản trị, thống kê và kiểm thử đạt.
- M6: Website trực tuyến và hồ sơ bàn giao hoàn chỉnh.

## 4. Điều kiện để đánh dấu hoàn thành

Mỗi buổi phải có:
- Mã nguồn hoặc tài liệu đầu ra.
- Lệnh kiểm tra hoặc ca kiểm thử phù hợp.
- Kết quả thực tế.
- Commit Git.
- Ghi chú lỗi còn tồn tại nếu có.

## 5. Các quyết định phải xác minh

- Phiên bản Laravel tương thích với yêu cầu môn học và hosting.
- Loại gói Hostinger và khả năng chạy Python/FastAPI.
- Tên miền và phương án HTTPS.
- Nguồn, giấy phép và điều kiện ghi công tài nguyên bảo tàng.
- Yêu cầu chính thức đối với báo cáo, kiểm thử và gói nộp.

## 6. Trạng thái hiện tại

Phần I đang được khởi tạo.
Các phần tiếp theo chưa được coi là đã hoàn thành.
